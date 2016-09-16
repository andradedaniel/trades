<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Trade;
use App\TradeEntrada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    public function index()
    {
        $trades = Auth::user()->trades;

        foreach($trades as $trade)
        {
            $volumeTotalEntrada = 0;
            $qtdEntradas = 0;
            $somaPrecosEntradas = 0;
            foreach($trade->tradeEntradas as $entrada)
            {
                $qtdEntradas++;
                $volumeTotalEntrada += $entrada->volume;
                $somaPrecosEntradas += $entrada->preco;
            }
            $trade->setQtdTotalEntradas($qtdEntradas);
            $trade->setVolumeTotalEntrada($volumeTotalEntrada);
            $trade->setPrecoMedioEntrada(round($somaPrecosEntradas/($qtdEntradas == 0 ? 1 : $qtdEntradas) ,2));


            $volumeTotalSaida = 0;
            $qtdSaidas = 0;
            $somaPrecosSaidas = 0;
            $volumeEmAberto = 0;
            foreach($trade->tradeSaidas as $saida)
            {
                $qtdSaidas++;
                $volumeTotalSaida += $saida->volume;
                $somaPrecosSaidas += $saida->preco;
            }
            $trade->setQtdTotalSaidas($qtdSaidas);
            $trade->setVolumeTotalSaida($volumeTotalSaida);
            $trade->setPrecoMedioSaida(round($somaPrecosSaidas/($qtdSaidas == 0 ? 1 : $qtdSaidas),2));

            $volumeEmAberto = $volumeTotalEntrada - $volumeTotalSaida;
            $trade->setVolumeEmAberto($volumeEmAberto);



//            dd($trade);
        }
//        dd($trades);
        return view('trades.index',['trades' => $trades]);
    }

    public function store(Request $request)
    {
//        dd($request);
        $trade = new Trade();
        $trade->ativo_id = 1;
        $trade->data = $request->data;
        $trade->tipo = $request->tipo;

        $trade = Auth::user()->trades()->save($trade);
        $tradeEntrada = new TradeEntrada();
        $tradeEntrada->preco = $request->preco_entrada;
        $tradeEntrada->volume = $request->volume;
        $trade->tradeEntradas()->save($tradeEntrada);

        return redirect()->route('trades.index');

    }

}
