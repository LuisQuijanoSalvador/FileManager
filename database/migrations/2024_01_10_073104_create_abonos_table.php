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
        Schema::create('abonos', function (Blueprint $table) {
            $table->id();
            $table->integer('idCargo');
            $table->integer('fechaAbono');
            $table->integer('monto');
            $table->integer('moneda');
            $table->integer('tipoCambio');
            $table->integer('idMedioPago');
            $table->integer('idBanco')->nullable();
            $table->integer('numeroCuenta')->nullable();
            $table->integer('idTarjetaCredito')->nullable();
            $table->integer('observaciones')->nullable();
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
        Schema::dropIfExists('abonos');
    }
};
