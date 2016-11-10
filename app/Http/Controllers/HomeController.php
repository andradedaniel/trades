<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Trade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        // QTD DE TRADES COM RESULTADO (LUCRO) POSITIVO E NEGATIVO
//        $totalTrades = Auth::user()->trades()->count();
        $totalTradesPositivos = Auth::user()->trades()->where('lucro_prejuizo_bruto', '>',0)->where('trade_aberto', '=',0)->count();
        $totalTradesNegativos = Auth::user()->trades()->where('lucro_prejuizo_bruto', '<',0)->where('trade_aberto', '=',0)->count();

        // LUCRO LIQUIDO POR MES DURANTE O ANO
        //TODO: permitir escolher o periodo na tela
        $ano=2016;
        $lucro_ano_temp = Auth::user()->trades()->select(\DB::raw("SUM(lucro_prejuizo_liquido) as total_lucro, month(data) as mes"))
                ->where(\DB::raw("year(data)"),'=',$ano)
                ->groupBy(\DB::raw("month(data)"))
                ->get()->toArray();
//dd($lucro_ano_temp);
        $lucro_ano_temp = array_column( $lucro_ano_temp, 'total_lucro', 'mes');
//        dd($lucro_ano_temp );
        for ($i=1;$i<=12;$i++){
            if ( ! isset($lucro_ano_temp[$i])){
                $lucro_ano[$i]['valor'] = 0;
            }else{
                $lucro_ano[$i]['valor'] = $lucro_ano_temp[$i];
            }
        }
        $lucro_ano = array_column( $lucro_ano, 'valor');


        // MEDIA DE PONTOS EM TRADES POSITIVOS E NEGATIVOS
        $media_pontos_positivos_temp = Auth::user()->trades()->select(\DB::raw("SUM(resultado) as media_resultado, month(data) as mes"))
            ->where('resultado', '>',0)
            ->where(\DB::raw("year(data)"),'=',$ano)
            ->groupBy(\DB::raw("month(data)"))
            ->get()->toArray();
//        dd($media_pontos_positivos_temp);
        $media_pontos_positivos_temp = array_column( $media_pontos_positivos_temp, 'media_resultado', 'mes');
        for ($i=1;$i<=12;$i++){
            if ( ! isset($media_pontos_positivos_temp[$i])){
                $media_pontos_positivos[$i]['valor'] = 0;
            }else{
                $media_pontos_positivos[$i]['valor'] = $media_pontos_positivos_temp[$i];
            }
        }
        $media_pontos_positivos = array_column( $media_pontos_positivos, 'valor');


        $media_pontos_negativos_temp = Auth::user()->trades()->select(\DB::raw("SUM(resultado) as media_resultado, month(data) as mes"))
            ->where('resultado', '<',0)
            ->where(\DB::raw("year(data)"),'=',$ano)
            ->groupBy(\DB::raw("month(data)"))
            ->get()->toArray();
//        dd($media_pontos_positivos_temp);
        $media_pontos_negativos_temp = array_column( $media_pontos_negativos_temp, 'media_resultado', 'mes');
        for ($i=1;$i<=12;$i++){
            if ( ! isset($media_pontos_negativos_temp[$i])){
                $media_pontos_negativos[$i]['valor'] = 0;
            }else{
                $media_pontos_negativos[$i]['valor'] = $media_pontos_negativos_temp[$i]*-1;
            }
        }
        $media_pontos_negativos = array_column( $media_pontos_negativos, 'valor');

//dd($media_pontos_positivos);




//        dd($lucro_ano);

        //total de trades na venda + % de acerto
        $totalTradesVenda = [];
        $totalTradesVenda['total'] = Auth::user()->trades()->where('tipo', '=','sell')->count();
        $totalTradesVenda['totalComLucro'] = Auth::user()->trades()->where('tipo', '=','sell')
            ->where('lucro_prejuizo_bruto', '>',0)
            ->count();

        //total de trades na compra + % de acerto
        //total de pontos positivo
        //total de pontos negativo
        //trade com maior prejuizo
        //trade com maior lucro
        //media de L/P no periodo
        //L/P liquido no periodo avaliado





        return view('home')
//                ->with('totalTrades',json_encode($totalTrades,JSON_NUMERIC_CHECK))
                ->with('totalTradesPositivos',json_encode($totalTradesPositivos,JSON_NUMERIC_CHECK))
                ->with('totalTradesNegativos',json_encode($totalTradesNegativos,JSON_NUMERIC_CHECK))
                ->with('lucro_ano',json_encode($lucro_ano,JSON_NUMERIC_CHECK))
                ->with('total_pontos_positivos',json_encode($media_pontos_positivos,JSON_NUMERIC_CHECK))
                ->with('total_pontos_negativos',json_encode($media_pontos_negativos,JSON_NUMERIC_CHECK))
                ->with('totalTradesVenda',$totalTradesVenda);
    }
}