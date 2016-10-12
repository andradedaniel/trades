<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $dates = ['data'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function ativo()
    {
        return $this->belongsTo('App\Ativo');
    }

    public function tradeOrdem()
    {
        return $this->hasMany('App\TradeOrdem');
    }

    public function existeTradeAberto()
    {
        $existe = Auth::user()->trades();
        return $existe;
    }
}
