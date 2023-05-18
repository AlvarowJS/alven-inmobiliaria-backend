<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Asesor;

class Cliente extends Model
{
    use HasFactory;
    public function asesor()
    {
        return $this->belongsTo(Asesor::class);
    }
}
