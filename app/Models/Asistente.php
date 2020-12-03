<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistente extends Model
{
    use HasFactory;
    protected $table = 'asistentes';

    protected $fillable = [
        'nombre',
        'paterno',
        'materno',
        'ci',
        'complemento',
        'telefono',
        'email',
        'institucion',
        'llave',
        'ingreso',
        'id_tipo_asistente'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
