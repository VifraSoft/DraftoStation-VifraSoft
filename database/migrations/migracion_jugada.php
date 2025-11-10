<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jugadas', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('partida_id')->nullable()
                  ->constrained('partidas')->nullOnDelete();

            $table->foreignId('jugador_id')
                  ->constrained('jugadores')->cascadeOnDelete();

            $table->foreignId('ficha_id')
                  ->constrained('fichas')->restrictOnDelete();

            $table->foreignId('recinto_id')
                  ->constrained('recintos')->restrictOnDelete();

            // Campos adicionales opcionales
            // $table->string('comentario', 255)->nullable();
            // $table->unsignedInteger('orden')->default(0);

            $table->timestamps();

            // Índices útiles
            $table->index(['partida_id', 'jugador_id']);
            $table->index(['partida_id', 'ficha_id']);
            $table->index(['partida_id', 'recinto_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jugadas');
    }
};
