<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Trade;
use App\TradeOperacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    public function index()
    {
        $trades = Auth::user()->trades;

//        foreach($trades as $trade)
//        {
//            $volumeTotalEntrada = 0;
//            $qtdEntradas = 0;
//            $somaPrecosEntradas = 0;
//            foreach($trade->tradeEntradas as $entrada)
//            {
//                $qtdEntradas++;
//                $volumeTotalEntrada += $entrada->volume;
//                $somaPrecosEntradas += $entrada->preco;
//            }
//            $trade->setQtdTotalEntradas($qtdEntradas);
//            $trade->setVolumeTotalEntrada($volumeTotalEntrada);
//            $trade->setPrecoMedioEntrada(round($somaPrecosEntradas/($qtdEntradas == 0 ? 1 : $qtdEntradas) ,2));
//
//
//            $volumeTotalSaida = 0;
//            $qtdSaidas = 0;
//            $somaPrecosSaidas = 0;
//            $volumeEmAberto = 0;
//            foreach($trade->tradeSaidas as $saida)
//            {
//                $qtdSaidas++;
//                $volumeTotalSaida += $saida->volume;
//                $somaPrecosSaidas += $saida->preco;
//            }
//            $trade->setQtdTotalSaidas($qtdSaidas);
//            $trade->setVolumeTotalSaida($volumeTotalSaida);
//            $trade->setPrecoMedioSaida(round($somaPrecosSaidas/($qtdSaidas == 0 ? 1 : $qtdSaidas),2));
//
//            $volumeEmAberto = $volumeTotalEntrada - $volumeTotalSaida;
//            $trade->setVolumeEmAberto($volumeEmAberto);



//            dd($trade);
//        }
//        dd($trades);
//        foreach ($trades as $trade)
//            dd($trade->preco_medio);
//
//        dd($trade->tradeOperacao);
        return view('trades.index',['trades' => $trades]);
    }

    public function store(Request $request)
    {
        //TODO: colocar try/catch
        //TODO: verificar se retornou mais de um trade aberto. Pois nao deve ser possivel $var->count()
        //TODO: verificar se o volume informado eh maior do q o volume em aberto
        //TODO: validar a data, se eh diferente da do trante aberto

        //        dd($request->all());
        //verifica se tem trade aberto:
        $tradeAberto = Auth::user()->trades()->where('trade_aberto','=',1)->first();
        if ($tradeAberto)
        {
            $tradeOperacao = new TradeOperacao();
            $tradeOperacao->tipo = $request->tipo;
            $tradeOperacao->volume = $request->volume;
            if ($tradeAberto->tipo != $request->tipo) //se eh diferente, eh pq ta fechando o trade
            {
                $invertForBuy = ($tradeAberto->tipo=='buy' ? -1 : 1);
                $tradeOperacao->in_or_out = 'out';
                $tradeOperacao->preco = $request->preco;
                $tradeOperacao->resultado = ($tradeAberto->preco_medio - $request->preco) * $invertForBuy;
                $tradeOperacao->lucro_prejuizo = $tradeOperacao->resultado * $request->volume * 0.2;
                if ($tradeAberto->volume_aberto == $request->volume)
                {
                    $tradeAberto->resultado = ($tradeAberto->preco_medio - $request->preco) * $invertForBuy;
                    $tradeAberto->lucro_prejuizo = $tradeAberto->resultado * $tradeAberto->volume * 0.2;
                    $tradeAberto->volume_aberto = 0;
                    $tradeAberto->trade_aberto = 'false';
                }
                else
                {
                    $tradeAberto->volume_aberto -= $request->volume;
                }

                \DB::transaction(function () use ($tradeAberto,$tradeOperacao) {
                    $tradeAberto->save();
                    $tradeAberto->tradeOperacao()->save($tradeOperacao);
                });
            }
            else //se nao, esta aumentao a mao no trade
            {
                $tradeOperacao->in_or_out = 'in';
                //TODO: revisar calculo de PM
                $tradeOperacao->preco = ($tradeAberto->preco_medio * $request->volume * $request->preco) / 2;
                $tradeAberto->volume += $request->volume;

            }
        }
        else
        {
            $trade = new Trade();
            $trade->ativo_id = 1;
            $trade->data = $request->data;
            $trade->tipo = $request->tipo;
            $trade->preco_medio = $request->preco;// TradeOperacao::calculaPrecoMedio($request->preco_entrada);
            $trade->volume = $request->volume; // atualizar volume
            $trade->volume_aberto = $request->volume; // atualizar volume em aberto

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
        dd($request);
    }


    public function destroy($idTrade)
    {
        //TODO: verificar se a operaçao eh do usuario logado
        //TODO: Usar try/catch
        //TODO: mostrar msg de confirmação antes de apagar
        \DB::transaction(function () use ($idTrade) {
            TradeOperacao::where('trade_id',$idTrade)->delete();
            Trade::destroy($idTrade);
        });

        return redirect()->route('trades.index');
    }

}


