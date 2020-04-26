<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $table = 'animais';

    public function raca()
    {
        return $this->belongsTo('App\Raca', 'id_raca');
    }

    public function lote()
    {
        return $this->belongsTo('App\Lote', 'id_lote');
    }
}
