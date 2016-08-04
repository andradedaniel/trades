<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TradeController extends Controller
{
    public function index($id)
    {
        return 'cod: '.$id;
    }

}
