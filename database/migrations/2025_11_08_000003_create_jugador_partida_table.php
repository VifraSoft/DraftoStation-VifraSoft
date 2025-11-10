<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jugador_partida', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partida_id')->constrained('partidas')->cascadeOnDelete();
            $table->foreignId('jugador_id')->constrained('jugadores')->cascadeOnDelete();
            $table->unsignedInteger('puntos')->default(0);
            $table->timestamps();

            $table->unique(['partida_id', 'jugador_id']); // mismo jugador una vez por partida
            $table->index(['puntos']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jugador_partida');
    }
};
