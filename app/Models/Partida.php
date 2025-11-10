<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Partida extends Model
{
    protected $table = 'partidas';
    protected $fillable = ['nombre_partida'];

    public function jugadores(): BelongsToMany
    {
        return $this->belongsToMany(Jugador::class, 'jugador_partida')
            ->withPivot(['puntos'])
            ->withTimestamps();
    }
}
