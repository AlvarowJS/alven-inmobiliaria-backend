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
            $table->string('numero_ofna');
            $table->date('fecha_alta');
            $table->string('tipo_operacion');
            $table->string('tipo_propiedad');
            $table->string('sub_tipo_propiedad');
            $table->string('tipo_contrato');
            $table->string('asesor_exclusivo')->nullable();
            $table->string('aceptar_creditos');
            // $table->date('fecha_credito');
            // $table->date('fecha_inicio');
            $table->string('operacion');
            // $table->string('porcentaje');
            // $table->string('duracion_dias');
            $table->string('requisito_arrendamiento');
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
