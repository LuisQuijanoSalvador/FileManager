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
        Schema::create('boleto_rutas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idBoleto');
            $table->integer('idAerolinea');
            $table->string('ciudadSalida');
            $table->string('ciudadLlegada');
            $table->string('vuelo');
            $table->string('clase');
            $table->date('fechaSalida');
            $table->string('horaSalida');
            $table->date('fechaLlegada');
            $table->string('horaLlegada');
            $table->string('farebasis')->nullable();
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
        Schema::dropIfExists('boleto_rutas');
    }
};
