<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TieneRecurso extends Model
{
    use HasFactory;
    protected $table = 'tiene_recurso';

    protected $fillable = [
        'id_recurso',
        'id_evento',
        'cantidad',
        'precio'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
