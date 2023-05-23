<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('basicos', function (Blueprint $table) {
            $table->id();
            $table->string('superficie_terreno');
            $table->string('superficie_construccion');
            $table->string('banios');
            $table->string('medios_banios');
            $table->string('recamaras');
            $table->string('cocina');
            $table->string('estacionamiento');
            $table->string('niveles_construidos');
            $table->string('cuota_mantenimiento');
            $table->string('numero_casas');
            $table->string('numero_elevadores');
            $table->string('piso_ubicado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basicos');
    }
};
