<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recinto extends Model
{
    protected $table = 'recintos';

    protected $fillable = [
        'nombre_recinto',
    ];

    // Relación útil (opcional) si usás Jugada con foreign key recinto_id:
    // public function jugadas() { return $this->hasMany(Jugada::class); }
}
