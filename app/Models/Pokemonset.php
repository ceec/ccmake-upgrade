<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pokemonset extends Model
{
    use HasFactory;

    // get all the cards in the set
    public function cards(): HasMany {
        return $this->hasMany(Pokemoncard::class, 'set_id', 'id');
    }

    public function cardsneeded() {
        $cards = Pokemoncard::where('set_id','=',$this->id)->get();

        // WOO it works, get all the cards I dont have in the set
        $cards = DB::table('pokemoncards')
        ->where('set_id','=',$this->id)
        ->whereNotIn('id',DB::table('pokemoncards')->where('set_id','=',$this->id)->join('pokemonusercards', 'pokemoncards.id', '=', 'pokemonusercards.pokemoncard_id')->pluck('pokemoncards.id'))
        ->get();

        return $cards;
    }
}
