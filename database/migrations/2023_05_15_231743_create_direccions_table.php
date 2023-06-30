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
            $table->foreignId('medio_id')->nullable()->constrained('medios');
            $table->string('pais')->nullable();
            $table->string('codigo_postal')->nullable();
            $table->string('estado')->nullable();
            $table->string('municipio')->nullable();
            $table->string('colonia')->nullable();
            $table->string('calle')->nullable();
            $table->string('numero')->nullable();
            $table->string('numero_interior')->nullable();
            $table->float('LAT')->nullable();
            $table->float('LON')->nullable();
            $table->float('ZOOM')->nullable();
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
