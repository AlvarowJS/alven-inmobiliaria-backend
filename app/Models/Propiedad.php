<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Publicidad;
use App\Models\Caracteristica;
use App\Models\General;
use App\Models\Direccion;
use App\Models\Cliente;
use App\Models\Foto;
class Propiedad extends Model
{
    use HasFactory;

    public function publicidad()
    {
        return $this->belongsTo(Publicidad::class);
    }
    public function caracteristica()
    {
        return $this->belongsTo(Caracteristica::class);
    }
    public function general()
    {
        return $this->belongsTo(General::class);
    }
    public function direccion()
    {
        return $this->belongsTo(Direccion::class);
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function foto()
    {
        return $this->hasMany(Foto::class);
    }

}
