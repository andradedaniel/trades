<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TradeOrdem extends Model
{
    public function trade()
    {
        return $this->belongsTo('App\Trade');
    }

//    public function calculaPrecoMedio($preco)
//    {
//
//    }
}
