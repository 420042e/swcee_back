<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    use HasFactory;
    protected $table = 'recurso';

    protected $fillable = [
        'nombre',
        'tipo'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
