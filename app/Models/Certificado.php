<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    use HasFactory;
    protected $table = 'certificados';

    protected $fillable = [
        'nombre',
        'width',
        'height',
        'id_membrete',
        'id_evento'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
