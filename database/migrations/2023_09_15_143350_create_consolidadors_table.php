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
        Schema::create('consolidadors', function (Blueprint $table) {
            $table->id();
            $table->string('razonSocial');
            $table->string('nombreComercial');
            $table->string('direccionFiscal');
            $table->string('direccionFacturacion');
            $table->integer('tipoProveedor');
            $table->integer('tipoDocumentoIdentidad');
            $table->string('numeroDocumentoIdentidad');
            $table->string('numeroTelefono')->nullable();
            $table->string('correo')->nullable();
            $table->decimal('montoCredito', $precision = 8, $scale = 4)->default(0);
            $table->integer('moneda');
            $table->integer('diasCredito')->default(0);
            $table->integer('tipoDocumento');
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
        Schema::dropIfExists('consolidadors');
    }
};
