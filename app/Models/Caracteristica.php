<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model
{
    use HasFactory;

    protected $fillable = [
        'mascotas',
        'espacios',
        'instalaciones',
        'restricciones',
        'extras',
        'youtube'
    ];
}
