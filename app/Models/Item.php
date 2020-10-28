<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';

    protected $fillable = [
        'tipo',
        'message',
        'fontSize',
        'pos_x',
        'pos_y',
        'id_certificado'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
