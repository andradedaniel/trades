<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carteira extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function ativos()
    {
        return $this->hasMany('App\Ativo');
    }
}
