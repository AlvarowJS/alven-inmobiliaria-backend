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
        Schema::create('asesors', function (Blueprint $table) {
            $table->id();
            $table->string("nombre")->nullable();
            $table->string("apellidos")->nullable();
            $table->string("rfc")->nullable();
            $table->string("direccion")->nullable();
            $table->string("email")->nullable();
            $table->string("celular")->nullable();
            $table->string("contacto_emergencia")->nullable();
            $table->string('foto')->nullable();
            $table->string('status')->nullable();
            $table->boolean('publico')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesors');
    }
};
