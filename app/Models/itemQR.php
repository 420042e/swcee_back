<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itemQR extends Model
{
    use HasFactory;
    protected $table = 'itemqr';

    protected $fillable = [
        'nombre',
        'pos_x',
        'pos_y',
        'id_certificado'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
