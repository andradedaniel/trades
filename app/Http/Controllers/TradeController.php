<?php

namespace App\Http\Controllers;

use App\Ativo;
use Carbon\Carbon;
use Gate;
use App\Http\Requests;
use App\Trade;
use App\TradeOrdem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    public function index($ativoId=1)
    {
        $mes = (isset($_GET['mes']) ? $_GET['mes'] : Carbon::now()->month);
        $ano = (isset($_GET['ano']) ? $_GET['ano'] : Carbon::now()->year);
//dd($mes);
        $trades = Auth::user()->trades()
                                ->where('ativo_id','=',$ativoId)
                                ->whereMonth('data', '=', $mes)
                                ->whereYear('data', '=', $ano)
                                ->orderBy('updated_at', 'DESC')
                                ->get();

//        $mesesToFilter = Trade::where('active', true)->orderBy('name')->pluck('name', 'id');

        return view('trades.index',['trades' => $trades, 'ativoId'=>$ativoId,'mes'=>$mes]);
    }

    public function store(Request $request)
    {
        //TODO: ver https://laravel.com/docs/5.3/validation#working-with-error-messages
        $this->validate($request, [
            'data' => 'required',
            'preco' => 'required',
            'tipo' => 'required',
            'volume' => 'required',
        ]);

        $totalTaxasOrdem = $this->calculaTotalTaxasOrdem($request->ativo_id, $request->volume);

        //TODO: colocar try/catch
        //TODO: verificar se retornou mais de um trade aberto. Pois nao deve ser possivel $var->count()
        //TODO: verificar se o volume informado eh maior do q o volume em aberto
        //TODO: validar a data, se eh diferente da do trade aberto

        //        dd($request->all());
        //verifica se tem trade aberto:
        $tradeAberto = Auth::user()->trades()->where('trade_aberto','=',1)->where('ativo_id','=',$request->ativo_id)->first();
        if ($tradeAberto)
        {
            $tradeOrdem = new TradeOrdem();
            $tradeOrdem->tipo = $request->tipo;
            $tradeOrdem->volume = $request->volume;
            $tradeOrdem->preco = $request->preco;
            $tradeOrdem->taxas = $totalTaxasOrdem;
            $tradeOrdem->lucro_prejuizo_liquido -= $totalTaxasOrdem;
            $tradeAberto->total_taxas += $totalTaxasOrdem;
            $tradeAberto->lucro_prejuizo_liquido -= $totalTaxasOrdem;
            if ($tradeAberto->tipo != $request->tipo) //se eh diferente, eh pq ta fechando o trade
            {
                $this->encerrarTrade2($tradeAberto,$tradeOrdem);
            }
            else //se nao, esta aumentao a mao no trade
            {
                $PMAntigo = ($tradeAberto->preco_medio * $tradeAberto->volume) + ($tradeOrdem->preco * $tradeOrdem->volume);

                $tradeOrdem->in_or_out = 'in';
                $tradeOrdem->taxas = $totalTaxasOrdem;
                $tradeAberto->volume += $tradeOrdem->volume;
                $tradeAberto->volume_aberto += $tradeOrdem->volume;
                $tradeAberto->preco_medio =  $PMAntigo / $tradeAberto->volume;

                try {
                    \DB::transaction(function () use ($tradeAberto, $tradeOrdem) {
                        $tradeAberto->save();
                        $tradeAberto->tradeOrdem()->save($tradeOrdem);
                    });

                } catch (Exception $e) {
                    throw $e;
                }

            }
        }
        else
        {
            $trade = new Trade();
            $trade->ativo_id = $request->ativo_id;
            $trade->data = $request->data;
            $trade->tipo = $request->tipo;
            $trade->preco_medio = $request->preco;
            $trade->volume = $request->volume;
            $trade->volume_aberto = $request->volume;
            $trade->total_taxas = $totalTaxasOrdem;
//            $trade->lucro_prejuizo_bruto -= $totalTaxasOrdem;
            $trade->lucro_prejuizo_liquido -= $totalTaxasOrdem;

            $tradeOrdem = new TradeOrdem();
            $tradeOrdem->tipo = $request->tipo;
            $tradeOrdem->in_or_out = 'in';
            $tradeOrdem->preco = $request->preco;
            $tradeOrdem->volume = $request->volume;
            $tradeOrdem->taxas = $totalTaxasOrdem;
//            $tradeOrdem->lucro_prejuizo_bruto -= $totalTaxasOrdem;
            $tradeOrdem->lucro_prejuizo_liquido -= $totalTaxasOrdem;



            \DB::transaction(function () use ($trade,$tradeOrdem) {
                $trade = Auth::user()->trades()->save($trade);
                $trade->tradeOrdem()->save($tradeOrdem);
            });

        }

        return redirect()->route('trades.index');

    }

    private function calculaTotalTaxasOrdem($idAtivo,$ordemVolume)
    {
        //TODO: buscar pelo ativo filtrando somente pelos ativos do usuario logado
        $ativo = Ativo::findOrFail($idAtivo);
        if ($ativo->tx_contrato_ou_ordem == 'contrato'){
            $totalTaxasOrdem = $ativo->taxas * $ordemVolume;
        }
        else {
            $totalTaxasOrdem = $ativo->taxas ;
        }

        return $totalTaxasOrdem;
    }

    public function encerrarTrade(Request $request)
    {
        //TODO: desabilitar botar de encerrar caso o trade_aberto = false
        //TODO: verificar o q fazer com return
        //TODO: verificar se o volume informado eh maior do q o volume em aberto
        $trade = Trade::findOrFail($request->id);

        $totalTaxasOrdem = $this->calculaTotalTaxasOrdem($trade->ativo_id,$request->volume);

        $tradeOrdem = new TradeOrdem();
        $tradeOrdem->tipo = ($trade->tipo=='buy' ? 'sell' : 'buy');
        $tradeOrdem->volume = $request->volume;
        $tradeOrdem->preco = $request->preco;
        $tradeOrdem->taxas = $totalTaxasOrdem;
        $tradeOrdem->lucro_prejuizo_liquido -= $totalTaxasOrdem;
        $trade->total_taxas += $totalTaxasOrdem;
        $trade->lucro_prejuizo_liquido -= $totalTaxasOrdem;
        //TODO: usar try/catch
        if ($this->encerrarTrade2($trade,$tradeOrdem))
        {
            return redirect()->route('trades.index');
        }
        return false;
    }

    private function encerrarTrade2($tradeAberto, $tradeOrdem)
    {
        //Verifica se o usuario logado tem permissao para atualizar o trade
        if (Gate::denies('update-delete-trade', $tradeAberto)) {
            return redirect()->route('trades.index')->withErrors(['Ops! Voce nao tem permissao para alterar este trade. :(']);
        }
        if ( ! $tradeAberto->trade_aberto) {
            return redirect()->route('trades.index')->withErrors(['Ops! Este trade ja esta encerrado. :(']);
        }
        if ($tradeOrdem->volume > $tradeAberto->volume_aberto){
            return redirect()->route('trades.index')->withInput()-> withErrors(['Ops! Informe um volume menor ou igual ao volume em aberto. :(']);
        }
        $invertForBuy = ($tradeAberto->tipo=='buy' ? -1 : 1); //necessario para calculo correto quando o trade eh de compra
        $tradeOrdem->in_or_out = 'out';
        $tradeOrdem->resultado = ($tradeAberto->preco_medio - $tradeOrdem->preco) * $invertForBuy;
        $tradeOrdem->lucro_prejuizo_bruto = $tradeOrdem->resultado * $tradeOrdem->volume * 0.2;
        $tradeOrdem->lucro_prejuizo_liquido += $tradeOrdem->lucro_prejuizo_bruto;

        $volFechadoAntes = $tradeAberto->volume - $tradeAberto->volume_aberto;
        $tradeAberto->volume_aberto -= $tradeOrdem->volume;
        $volFechadoFinal = $tradeAberto->volume - $tradeAberto->volume_aberto;

        $tradeAberto->resultado = ((($tradeAberto->resultado * $volFechadoAntes)
                                    + (( $tradeAberto->preco_medio - $tradeOrdem->preco) * $tradeOrdem->volume))
                                    / $volFechadoFinal) * $invertForBuy;

        $tradeAberto->lucro_prejuizo_bruto += $tradeOrdem->lucro_prejuizo_bruto;
        $tradeAberto->lucro_prejuizo_liquido += $tradeOrdem->lucro_prejuizo_bruto;

        if ($tradeAberto->volume_aberto == 0)
            $tradeAberto->trade_aberto = 'false';

        try {
            \DB::transaction(function () use ($tradeAberto, $tradeOrdem) {
                $tradeAberto->save();
                $tradeAberto->tradeOrdem()->save($tradeOrdem);
            });
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function destroy($idTrade)
    {

        $trade = Trade::findOrFail($idTrade);
        //Verifica se o usuario logado tem permissao para excluir o trade
        if (Gate::denies('update-delete-trade', $trade)) {
            return redirect()->route('trades.index')->withErrors(['Ops! Voce nao tem permissao para remover este trade. :(']);
        }

        //TODO: Usar try/catch
        //TODO: mostrar msg de confirmação antes de apagar:
        // http://stackoverflow.com/questions/8982295/confirm-delete-modal-dialog-with-twitter-bootstrap
        \DB::transaction(function () use ($idTrade) {
            TradeOrdem::where('trade_id',$idTrade)->delete();
            Trade::destroy($idTrade);
        });

        return redirect()->route('trades.index');
    }
}