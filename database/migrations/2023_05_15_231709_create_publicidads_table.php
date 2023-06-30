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
        Schema::create('publicidads', function (Blueprint $table) {
            $table->id();
            $table->double('precio_venta')->nullable();
            $table->string('encabezado')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('video_url')->nullable();
            $table->string('estado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicidads');
    }
};
