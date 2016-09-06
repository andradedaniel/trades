<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $dates = ['data'];
    protected $volumeTotalEntrada = 0;
    protected $qtdEntradas = 0;
    protected $precoMedioEntrada = 0;

    protected $volumeTotalSaida = 0;
    protected $qtdSaidas = 0;
    protected $precoMedioSaida = 0;

    protected $volumeEmAberto = 0;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function ativo()
    {
        return $this->belongsTo('App\Ativo');
    }

    public function tradeEntradas()
    {
        return $this->hasMany('App\TradeEntrada');
    }

    public function tradeSaidas()
    {
        return $this->hasMany('App\TradeSaida');
    }



    /** Getters and Setters ENTRADAS */

    public function getVolumeTotalEntrada()
    {
        return $this->volumeTotalEntrada;
    }

    public function setVolumeTotalEntrada($value)
    {
        $this->volumeTotalEntrada = $value;
    }

    public function getQtdTotalEntradas()
    {
        return $this->qtdEntradas;
    }

    public function setQtdTotalEntradas($value)
    {
        $this->qtdEntradas = $value;
    }

    public function getPrecoMedioEntrada()
    {
        return $this->precoMedioEntrada;
    }

    public function setPrecoMedioEntrada($value)
    {
        $this->precoMedioEntrada = $value;
    }



    /** Getters and Setters SAIDAS */

    public function getVolumeTotalSaida()
    {
        return $this->volumeTotalSaida;
    }

    public function setVolumeTotalSaida($value)
    {
        $this->volumeTotalSaida = $value;
    }

    public function getQtdTotalSaidas()
    {
        return $this->qtdSaidas;
    }

    public function setQtdTotalSaidas($value)
    {
        $this->qtdSaidas = $value;
    }

    public function getPrecoMedioSaida()
    {
        return $this->precoMedioSaida;
    }

    public function setPrecoMedioSaida($value)
    {
        $this->precoMedioSaida = $value;
    }

    /* **************************************** */

    public function getVolumeEmAberto()
    {
        return $this->volumeEmAberto;
    }

    public function setVolumeEmAberto($value)
    {
        $this->volumeEmAberto = $value;
    }

}
