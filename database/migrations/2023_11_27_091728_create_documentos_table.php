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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->integer('idCliente');
            $table->string('razonSocial');
            $table->string('direccionFiscal');
            $table->string('numeroDocumentoIdentidad');
            $table->integer('idTipoDocumento');
            $table->string('tipoDocumento');
            $table->string('serie');
            $table->string('numero');
            $table->integer('idMoneda');
            $table->string('moneda');
            $table->date('fechaEmision');
            $table->date('fechaVencimiento');
            $table->decimal('afecto');
            $table->decimal('inafecto');
            $table->decimal('exonerado');
            $table->decimal('igv');
            $table->decimal('otrosImpuestos');
            $table->decimal('total');
            $table->string('glosa');
            $table->string('documentoReferencia');
            $table->integer('idMotivoNC');
            $table->integer('idMotivoND');
            $table->decimal('tipoCambio');
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
        Schema::dropIfExists('documentos');
    }
};
