<?php

namespace App\Models;

use Auth;
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
        // $cards = Pokemoncard::where('set_id','=',$this->id)->get();

        // // WOO it works, get all the cards I dont have in the set
        // $cards = DB::table('pokemoncards')
        // ->where('set_id','=',$this->id)
        // ->whereNotIn('id',DB::table('pokemoncards')->where('set_id','=',$this->id)->join('pokemonusercards', 'pokemoncards.id', '=', 'pokemonusercards.pokemoncard_id')->pluck('pokemoncards.id'))
        // ->get();

        // return $cards;

        if ( !Auth::guest() ) {
            $usercards = Pokemonusercard::where('user_id','=',Auth::user()->id)->pluck('pokemoncard_id')->toArray();
            $cards = Pokemoncard::whereNotIn('id',$usercards)->where('set_id','=',$this->id)->get();
        } else {
            $cards = Pokemoncard::where('set_id','=',$this->id)->get();
        }

        return $cards;

    }

    public function totalcards() {
        $cards = Pokemoncard::where('set_id','=',$this->id)->get();
        $total = $cards->count();

        return $total;
    }

    public function totalhavecards() {
        $cards = DB::table('pokemoncards')
        ->where('set_id','=',$this->id)
        ->whereIn('id',DB::table('pokemoncards')->where('set_id','=',$this->id)->join('pokemonusercards', 'pokemoncards.id', '=', 'pokemonusercards.pokemoncard_id')->pluck('pokemoncards.id'))
        ->get();       
        
        $total = $cards->count();

        return $total;
    } 
    
    public function totalneedcards() {
        $cards = DB::table('pokemoncards')
        ->where('set_id','=',$this->id)
        ->whereNotIn('id',DB::table('pokemoncards')->where('set_id','=',$this->id)->join('pokemonusercards', 'pokemoncards.id', '=', 'pokemonusercards.pokemoncard_id')->pluck('pokemoncards.id'))
        ->get();       
        
        $total = $cards->count();

        return $total;
    }      
}
