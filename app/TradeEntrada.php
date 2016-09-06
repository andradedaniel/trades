<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TradeEntrada extends Model
{
    public function trade()
    {
        return $this->belongsTo('App\Trade');
    }
}
