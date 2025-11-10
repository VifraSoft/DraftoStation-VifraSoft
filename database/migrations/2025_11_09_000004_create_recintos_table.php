<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recintos', function (Blueprint $table) {
            $table->id();
            // guarda exactamente los nombres que usás (incluye ñ y guiones bajos)
            $table->string('nombre_recinto', 64)->unique();
            $table->timestamps();

            // Si querés fijar charset/collation explícitamente (MySQL):
            // $table->charset   = 'utf8mb4';
            // $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recintos');
    }
};
