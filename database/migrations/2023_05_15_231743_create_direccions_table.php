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
        Schema::create('direccions', function (Blueprint $table) {
            $table->id();
            $table->string('pais');
            $table->string('codigo_postal');
            $table->string('estado');
            $table->string('municipio');
            $table->string('colonia');
            $table->string('calle');
            $table->string('numero');
            $table->float('LAT');
            $table->float('LON');
            $table->float('ZOOM');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direccions');
    }
};
