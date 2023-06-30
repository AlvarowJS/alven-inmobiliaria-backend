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
            $table->string('superficie_terreno')->nullable();
            $table->string('superficie_construccion')->nullable();
            $table->string('banios')->nullable();
            $table->string('medios_banios')->nullable();
            $table->string('recamaras')->nullable();
            $table->string('cocina')->nullable();
            $table->string('estacionamiento')->nullable();
            $table->string('niveles_construidos')->nullable();
            $table->string('cuota_mantenimiento')->nullable();
            $table->string('numero_casas')->nullable();
            $table->string('numero_elevadores')->nullable();
            $table->string('piso_ubicado')->nullable();
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
