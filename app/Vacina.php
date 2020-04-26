<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacina extends Model
{
    public function lotes()
    {
        return $this->belongsToMany('App\Lote','loteVacina','vacina_id','lote_id')
            ->withPivot('id','dosagem');
    }
}
