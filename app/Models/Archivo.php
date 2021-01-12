<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;
    protected $table = 'archivos';

    protected $fillable = [
        'nombre',
        'id_evento'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
