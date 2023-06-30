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
        Schema::create('generals', function (Blueprint $table) {
            $table->id();
            $table->string('numero_ofna')->nullable();
            $table->date('fecha_alta')->nullable();
            $table->string('tipo_operacion')->nullable();
            $table->string('tipo_propiedad')->nullable();
            $table->string('sub_tipo_propiedad')->nullable();
            $table->string('tipo_contrato')->nullable();
            $table->string('asesor_exclusivo')->nullable()->nullable();
            $table->string('aceptar_creditos')->nullable();
            // $table->date('fecha_credito');
            // $table->date('fecha_inicio');
            $table->string('operacion')->nullable();
            // $table->string('porcentaje')->nullable();
            // $table->string('duracion_dias')->nullable();
            $table->string('requisito_arrendamiento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generals');
    }
};
