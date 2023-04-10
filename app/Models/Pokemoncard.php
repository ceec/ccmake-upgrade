<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pokemoncard extends Model
{
    use HasFactory;

    /**
     * find the user that has this card? maybe?
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Pokemonusercard::class);
    }    
}
