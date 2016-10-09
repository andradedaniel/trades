<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
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
//        $a = Auth::user()->carteiras;
//        foreach ($a as $x){
//                print_r($x->nome);
//                //print_r($x->ativos);
//            if ($x->ativos->isEmpty())
//                echo 'karaiii';
//                //$x->ativos = array('nome'=>'kkkkkk');
////            echo $x->nome;
////            foreach ($x->ativos as $ativo) {
////                var_dump($x->nome);
////
//        }
//        die;
//        return view('home',['carteiras' => Auth::user()->carteiras]);
        return view('home');
    }
}