<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

//    public function carteiras()
//    {
//        return $this->hasMany('App\Carteira');
//    }

    public function trades()
    {
        return $this->hasMany('App\Trade');
    }

    public function ativos()
    {
        return $this->hasMany('App\Ativo');
    }
}
