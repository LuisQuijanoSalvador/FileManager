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
            $table->boolean('detraccion')->default(false);
            $table->decimal('afecto');
            $table->decimal('inafecto');
            $table->decimal('exonerado');
            $table->decimal('igv');
            $table->decimal('otrosImpuestos');
            $table->decimal('total');
            $table->string('totalLetras')->nullable();
            $table->string('glosa')->nullable();
            $table->string('numeroFile')->nullable();
            $table->string('tipoServicio');
            $table->string('documentoReferencia')->nullable();
            $table->integer('idMotivoNC')->nullable();
            $table->integer('idMotivoND')->nullable();
            $table->decimal('tipoCambio');
            $table->integer('idEstado');
            $table->string('respuestaSunat')->nullable();
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
