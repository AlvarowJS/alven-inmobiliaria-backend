<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicidadLiga extends Model
{
    protected $table = 'publicidad_ligas';
    protected $primaryKey = 'id';
    public function publicidad()
    {
        return $this->belongsTo(Publicidad::class, 'publicidad_id', 'id');
    }

    protected $fillable = ['publicidad_id', 'red_social', 'enlace'];
    public $timestamps = false;

}
