<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Custo_Animal extends Model
{
    protected $table = 'custos_animais';

    public function animal()
    {
        return $this->belongsTo('App\Animal', 'id_animais');
    }
}
