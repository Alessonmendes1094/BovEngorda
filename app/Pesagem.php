<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pesagem extends Model
{
    protected $table = 'pesagens';

    public function animal()
    {
        return $this->belongsTo('App\Animal');
    }
}
