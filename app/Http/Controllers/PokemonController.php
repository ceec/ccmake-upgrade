<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Set;

class PokemonController extends Controller
{

    /**
     * Set - from the given set (base set) list all the cards in that set
     *
     * @return \Illuminate\Http\Response
     */
    public function set($set){
        // get info on the set
        $setinfo = Set::where('url','=',$set)->first();

        // get all the cards in that set
        $cards = Card::where('set_id','=',$setinfo->id)->get();

        return  view('pages.pokemonset')
        ->with('set',$setinfo)
        ->with('cards',$cards);
    }

    //card
    // display a specific card
}
