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
        Schema::create('file_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('idFile');
            $table->string('numeroFile');
            $table->integer('idServicio')->nullable();
            $table->integer('idBoleto')->nullable();
            $table->integer('idEstado');
            $table->integer('usuarioCreacion');
            $table->integer('usuarioModificacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_detalles');
    }
};
