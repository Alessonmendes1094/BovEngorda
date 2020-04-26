<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Vacina;

class Lote extends Model
{
    public function vacinas()
    {
        return $this->belongsToMany('App\Vacina','loteVacina' , 'lote_id','vacina_id')
            ->withPivot('id','dosagem');
    }
}
