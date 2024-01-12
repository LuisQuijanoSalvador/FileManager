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
        Schema::create('cargos', function (Blueprint $table) {
            $table->id();
            $table->integer('idDocumento');
            $table->integer('idCliente');
            $table->integer('idCobrador');
            $table->integer('idCounter');
            $table->integer('idAerolinea');
            $table->integer('idSolicitante');
            $table->integer('idBoleto')->nullable();
            $table->integer('idServicio')->nullable();
            $table->decimal('montoCredito');
            $table->integer('diasCredito');
            $table->date('fechaEmision');
            $table->date('fechaVencimiento');
            $table->string('numeroBoleto');
            $table->string('pasajero');
            $table->string('tipoRuta');
            $table->string('ruta');
            $table->string('moneda');
            $table->decimal('tafifaNeta');
            $table->decimal('inafecto');
            $table->decimal('igv');
            $table->decimal('otrosImpuestos');
            $table->decimal('total');
            $table->string('tipoDocumento');
            $table->integer('serieDocumento');
            $table->string('numeroDocumento');
            $table->decimal('montoCargo');
            $table->decimal('tipoCambio');
            $table->decimal('saldo');
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
        Schema::dropIfExists('cargos');
    }
};
