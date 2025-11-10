<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jugada extends Model
{
    protected $table = 'jugadas';

    protected $fillable = [
        'partida_id',
        'jugador_id',
        'ficha_id',
        'recinto_id',
    ];

    public function partida(): BelongsTo { return $this->belongsTo(Partida::class); }
    public function jugador(): BelongsTo { return $this->belongsTo(Jugador::class); }
    public function ficha(): BelongsTo   { return $this->belongsTo(Ficha::class); }
    public function recinto(): BelongsTo { return $this->belongsTo(Recinto::class); }
}
