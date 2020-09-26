<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    protected $table = 'eventos';

    protected $fillable = [
        'nombre_evento',
        'lugar',
        'fecha',
        'hora',
        'estado',
        'tipo',
        'descripcion'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
