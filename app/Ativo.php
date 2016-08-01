<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ativo extends Model
{
    public function carteira()
    {
        return $this->belongsTo('App\Carteira');
    }
}
