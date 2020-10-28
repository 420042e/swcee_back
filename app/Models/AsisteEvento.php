<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsisteEvento extends Model
{
    use HasFactory;
    protected $table = 'asiste_evento';

    protected $fillable = [
        'id_asistente',
        'id_evento'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
