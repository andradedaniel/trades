<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    public function index($id=1)
    {
//        $a = Auth::user()->trades;
//        dd($a);
        return view('trades.index',['trades' => Auth::user()->trades()->paginate(5)]);
    }

}
