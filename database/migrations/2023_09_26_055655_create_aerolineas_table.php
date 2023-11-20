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
        Schema::create('aerolineas', function (Blueprint $table) {
            $table->id();
            $table->string('razonSocial');
            $table->string('nombreComercial');
            $table->string('siglaIata');
            $table->string('codigoIata');
            $table->string('ruc');
            $table->string('logo');
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
        Schema::dropIfExists('aerolineas');
    }
};
