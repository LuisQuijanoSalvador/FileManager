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
        Schema::create('servicio_pagos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idServicio');
            $table->integer('idMedioPago');
            $table->integer('idTarjetaCredito')->nullable();
            $table->string('numeroTarjeta')->nullable();
            $table->decimal('monto');
            $table->string('fechaVencimientoTC')->nullable();
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
        Schema::dropIfExists('servicio_pagos');
    }
};
