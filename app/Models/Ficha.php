<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ficha extends Model
{
    protected $table = 'fichas';

    protected $fillable = [
        'nombre',
    ];

    public function jugadas(): HasMany
    {
        return $this->hasMany(Jugada::class, 'ficha_id');
    }
}
