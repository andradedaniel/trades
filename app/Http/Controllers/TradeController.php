<?php

namespace App\Http\Controllers;

use Gate;
use App\Http\Requests;
use App\Trade;
use App\TradeOperacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    public function index()
    {
        $trades = Auth::user()->trades()->orderBy('data', 'DESC')->get();

        return view('trades.index',['trades' => $trades]);
    }

    public function store(Request $request)
    {
        //TODO: ver https://laravel.com/docs/5.3/validation#working-with-error-messages
        $this->validate($request, [
            'preco' => 'required',
            'tipo' => 'required',
            'volume' => 'required',
        ]);

        //TODO: colocar try/catch
        //TODO: verificar se retornou mais de um trade aberto. Pois nao deve ser possivel $var->count()
        //TODO: verificar se o volume informado eh maior do q o volume em aberto
        //TODO: validar a data, se eh diferente da do trade aberto

        //        dd($request->all());
        //verifica se tem trade aberto:
        $tradeAberto = Auth::user()->trades()->where('trade_aberto','=',1)->first();
        if ($tradeAberto)
        {
            $tradeOperacao = new TradeOperacao();
            $tradeOperacao->tipo = $request->tipo;
            $tradeOperacao->volume = $request->volume;
            $tradeOperacao->preco = $request->preco;
            if ($tradeAberto->tipo != $request->tipo) //se eh diferente, eh pq ta fechando o trade
            {
                $this->encerrarTrade2($tradeAberto,$tradeOperacao);
            }
            else //se nao, esta aumentao a mao no trade
            {
                $PMAntigo = ($tradeAberto->preco_medio * $tradeAberto->volume) + ($tradeOperacao->preco * $tradeOperacao->volume);

                $tradeOperacao->in_or_out = 'in';
                $tradeAberto->volume += $tradeOperacao->volume;
                $tradeAberto->volume_aberto += $tradeOperacao->volume;
                $tradeAberto->preco_medio =  $PMAntigo / $tradeAberto->volume;

                try {
                    \DB::transaction(function () use ($tradeAberto, $tradeOperacao) {
                        $tradeAberto->save();
                        $tradeAberto->tradeOperacao()->save($tradeOperacao);
                    });

                } catch (Exception $e) {
                    throw $e;
                }

            }
        }
        else
        {
            $trade = new Trade();
            $trade->ativo_id = 1;
            $trade->data = $request->data;
            $trade->tipo = $request->tipo;
            $trade->preco_medio = $request->preco;
            $trade->volume = $request->volume;
            $trade->volume_aberto = $request->volume;

            $tradeOperacao = new TradeOperacao();
            $tradeOperacao->tipo = $request->tipo;
            $tradeOperacao->in_or_out = 'in';
            $tradeOperacao->preco = $request->preco;
            $tradeOperacao->volume = $request->volume;


            \DB::transaction(function () use ($trade,$tradeOperacao) {
                $trade = Auth::user()->trades()->save($trade);
                $trade->tradeOperacao()->save($tradeOperacao);
            });

        }

        return redirect()->route('trades.index');

    }

    public function encerrarTrade(Request $request)
    {
        //TODO: desabilitar botar de encerrar caso o trade_aberto = false
        //TODO: verificar o q fazer com return
        //TODO: verificar se o volume informado eh maior do q o volume em aberto

        $trade = Trade::findOrFail($request->id);



        $tradeOperacao = new TradeOperacao();
        $tradeOperacao->tipo = ($trade->tipo=='buy' ? 'sell' : 'buy');
        $tradeOperacao->volume = $request->volume;
        $tradeOperacao->preco = $request->preco;
        //TODO: usar try/catch
        if ($this->encerrarTrade2($trade,$tradeOperacao))
        {
            return redirect()->route('trades.index');
        }
        return false;
    }

    private function encerrarTrade2($tradeAberto, $tradeOperacao)
    {
        //Verifica se o usuario logado tem permissao para atualizar o trade
        if (Gate::denies('update-delete-trade', $tradeAberto)) {
            return redirect()->route('trades.index')->withErrors(['Ops! Voce nao tem permissao para alterar este trade. :(']);
        }
        if ( ! $tradeAberto->trade_aberto) {
            return redirect()->route('trades.index')->withErrors(['Ops! Este trade ja esta encerrado. :(']);
        }
        if ($tradeOperacao->volume > $tradeAberto->volume_aberto){
            return redirect()->route('trades.index')->withInput()-> withErrors(['Ops! Informe um volume menor ou igual ao volume em aberto. :(']);
        }
        $invertForBuy = ($tradeAberto->tipo=='buy' ? -1 : 1);
        $tradeOperacao->in_or_out = 'out';
        $tradeOperacao->resultado = ($tradeAberto->preco_medio - $tradeOperacao->preco) * $invertForBuy;
        $tradeOperacao->lucro_prejuizo = $tradeOperacao->resultado * $tradeOperacao->volume * 0.2;
//        if ($tradeAberto->volume_aberto == $tradeOperacao->volume) {
//            $tradeAberto->resultado = ($tradeAberto->preco_medio - $tradeOperacao->preco) * $invertForBuy;
//            $tradeAberto->lucro_prejuizo = $tradeAberto->resultado * $tradeAberto->volume * 0.2;
//            $tradeAberto->volume_aberto = 0;
//            $tradeAberto->trade_aberto = 'false';
//        } else {
//            $tradeAberto->volume_aberto -= $tradeOperacao->volume;
//        }

        $tradeAberto->resultado = ($tradeAberto->preco_medio - $tradeOperacao->preco) * $invertForBuy;
        $tradeAberto->lucro_prejuizo += $tradeOperacao->lucro_prejuizo;
        $tradeAberto->volume_aberto -= $tradeOperacao->volume;
        if ($tradeAberto->volume_aberto == 0)
            $tradeAberto->trade_aberto = 'false';

        try {
            \DB::transaction(function () use ($tradeAberto, $tradeOperacao) {
                $tradeAberto->save();
                $tradeAberto->tradeOperacao()->save($tradeOperacao);
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
            TradeOperacao::where('trade_id',$idTrade)->delete();
            Trade::destroy($idTrade);
        });

        return redirect()->route('trades.index');
    }

}