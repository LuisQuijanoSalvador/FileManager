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
        Schema::create('boletos', function (Blueprint $table) {
            $table->id();
            $table->string('numeroBoleto');
            $table->string('numeroFile');
            $table->integer('idCliente');
            $table->integer('idSolicitante')->nullable();
            $table->date('fechaEmision');
            $table->integer('idCounter');
            $table->integer('idTipoFacturacion');
            $table->integer('idTipoDocumento');
            $table->integer('idArea');
            $table->integer('idVendedor');
            $table->integer('idConsolidador')->nullable();
            $table->string('codigoReserva');
            $table->date('fechaReserva');
            $table->integer('idGds');
            $table->integer('idTipoTicket');
            $table->string('tipoRuta');
            $table->string('tipoTarifa');
            $table->integer('idAerolinea');
            $table->string('origen');
            $table->string('pasajero');
            $table->string('idTipoPasajero');
            $table->string('ruta')->nullable();
            $table->string('destino')->nullable();
            $table->bigInteger('idDocumento')->nullable();
            $table->decimal('tipoCambio');
            $table->integer('idMoneda');
            $table->decimal('tarifaNeta');
            $table->decimal('inafecto');
            $table->decimal('igv');
            $table->decimal('otrosImpuestos')->nullable();
            $table->decimal('xm')->nullable();
            $table->decimal('total');
            $table->decimal('totalOrigen');
            $table->decimal('porcentajeComision')->nullable();
            $table->decimal('montoComision')->nullable();
            $table->decimal('descuentoCorporativo')->nullable();
            $table->string('codigoDescCorp')->nullable();
            $table->decimal('tarifaNormal')->nullable();
            $table->decimal('tarifaAlta')->nullable();
            $table->decimal('tarifaBaja')->nullable();
            $table->integer('idTipoPagoConsolidador');
            $table->string('centroCosto')->nullable();
            $table->string('cod1')->nullable();
            $table->string('cod2')->nullable();
            $table->string('cod3')->nullable();
            $table->string('cod4')->nullable();
            $table->string('observaciones')->nullable();
            $table->integer('estado');
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
        Schema::dropIfExists('boletos');
    }
};
