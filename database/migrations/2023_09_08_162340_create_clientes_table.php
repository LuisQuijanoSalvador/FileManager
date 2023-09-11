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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('razonSocial');
            $table->string('nombreComercial');
            $table->string('direccionFiscal');
            $table->string('direccionFacturacion');
            $table->integer('tipoCliente');
            $table->integer('tipoDocumentoIdentidad');
            $table->string('numeroDocumentoIdentidad');
            $table->string('numeroTelefono');
            $table->string('contactoComercial');
            $table->string('telefonoComercial');
            $table->string('correoComercial');
            $table->string('contactoCobranza');
            $table->string('telefonoCobranza');
            $table->string('correoCobranza');
            $table->decimal('montoCredito', $precision = 8, $scale = 4);
            $table->integer('moneda');
            $table->integer('diasCredito');
            $table->integer('counter');
            $table->integer('tipoDocumento');
            $table->integer('vendedor');
            $table->integer('area');
            $table->integer('cobrador');
            $table->integer('tipoFacturacion');
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
        Schema::dropIfExists('clientes');
    }
};
