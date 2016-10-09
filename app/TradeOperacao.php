<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TradeOperacao extends Model
{
    public function trade()
    {
        return $this->belongsTo('App\Trade');
    }

    public function calculaPrecoMedio($preco)
    {

    }
}
