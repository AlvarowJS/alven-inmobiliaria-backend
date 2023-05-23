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
        Schema::create('propiedads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('general_id')->nullable()->constrained('generals');
            $table->foreignId('direccion_id')->nullable()->constrained('direccions');
            $table->foreignId('caracteristica_id')->nullable()->constrained('caracteristicas');
            $table->foreignId('publicidad_id')->nullable()->constrained('publicidads');
            $table->foreignId('cliente_id')->nullable()->constrained('clientes');
            $table->foreignId('basico_id')->nullable()->constrained('basicos');
            $table->boolean("estado")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propiedads');
    }
};
