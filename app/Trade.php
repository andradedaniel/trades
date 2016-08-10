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
}
