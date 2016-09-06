<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TradeSaida extends Model
{
    public function trade()
    {
        return $this->belongsTo('App\Trade');
    }
}
