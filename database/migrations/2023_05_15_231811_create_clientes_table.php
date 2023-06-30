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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesor_id')->nullable()->constrained('asesors');
            $table->string("nombre")->nullable();
            $table->string("apellido_materno")->nullable();
            $table->string("apellido_paterno")->nullable();
            $table->string("cedula")->nullable();
            $table->string("email")->nullable();
            $table->string("celular")->nullable();
            $table->string("tipo_cliente")->nullable();
            $table->string("medio_contacto")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
