<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Custo extends Model
{
    protected $fillable = ['titulo','tipo','descricao'];
    
    protected $casts = [
        'data' => 'date',
    ];
}
