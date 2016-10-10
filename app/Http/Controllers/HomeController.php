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
//        $trades = Trade::count()->where('user_id','=',Auth::user()->id);
        $totalTrades = Auth::user()->trades()->count();
        $totalTradesPositivos = Auth::user()->trades()->where('lucro_prejuizo_bruto', '>',0)->count();
        $totalTradesNegativos = Auth::user()->trades()->where('lucro_prejuizo_bruto', '<',0)->count();
//        dd($totalTradesNegativos);
//
        return view('home')
                ->with('totalTrades',json_encode($totalTrades,JSON_NUMERIC_CHECK))
                ->with('totalTradesPositivos',json_encode($totalTradesPositivos,JSON_NUMERIC_CHECK))
                ->with('totalTradesNegativos',json_encode($totalTradesNegativos,JSON_NUMERIC_CHECK));
    }
}