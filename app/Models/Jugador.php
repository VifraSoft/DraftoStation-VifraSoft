<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Jugador extends Model
{
    protected $table = 'jugadores';
    protected $fillable = ['nombre'];

    public function partidas(): BelongsToMany
    {
        return $this->belongsToMany(Partida::class, 'jugador_partida')
            ->withPivot(['puntos'])
            ->withTimestamps();
    }
}
