<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailRegistro extends Model
{
    use HasFactory;
    protected $table = 'email_registro';

    protected $fillable = [
        'titulo',
        'contenido'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
