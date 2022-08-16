<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pokemoncard;
use App\Models\Pokemonset;
use App\Models\Pokemonusercard;

class PokemonController extends Controller
{

    /**
     * Set - from the given set (base set) list all the cards in that set
     *
     * @return \Illuminate\Http\Response
     */
    public function set($set){
        // get info on the set
        $setinfo = Pokemonset::where('url','=',$set)->first();

        // get all the cards in that set, add on if I have the card or not
        // TODO: If i have multiple it displays it twice
        $cards = DB::table('pokemoncards')
        ->where('set_id','=',$setinfo->id)
        ->leftJoin('pokemonusercards', 'pokemoncards.id', '=', 'pokemonusercards.pokemoncard_id')
        ->get();

        return  view('pages.pokemonset')
        ->with('set',$setinfo)
        ->with('cards',$cards);
    }

    //card
    // display a specific card
}
