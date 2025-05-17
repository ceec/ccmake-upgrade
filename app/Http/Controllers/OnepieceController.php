<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Onepiecencard;
use App\Models\Onepieceset;
use App\Models\Onepieceusercard;
use App\Models\Onepiececharacter;

class OnepieceController extends Controller
{

    /**
     * Set - from the given set (base set) list all the cards in that set
     *
     * @return \Illuminate\Http\Response
     */
    public function set($set){
        // get info on the set
        $setinfo = Onepieceset::where('url','=',$set)->first();

        // get all the cards in that set, add on if I have the card or not
        // TODO: If i have multiple it displays it twice
        $cards = DB::table('onepiececards')
        ->where('set_id','=',$setinfo->id)
        ->select('onepiececards.*','onepieceusercards.*','onepiecesets.url as set_url','onepiecesets.imagename as set_imagename')
        ->leftJoin('onepieceusercards', 'onepiececards.id', '=', 'onepieceusercards.onepiececard_id')
        ->leftJoin('onepiecesets','onepiececards.originaL_set_id','=','onepiecesets.id')
        ->get();

        return  view('pages.onepieceset')
        ->with('set',$setinfo)
        ->with('cards',$cards);
    }

    //card
    // display a specific card



    // need - cards I need
    // only going to do wotc first
    public function need($set) {
        // ok figuring out cards I need
        // have list of all the cards in the set, then have my list of cards in the set, so i can do one
        // of those sql things thats like exclude
        // so want all of pokmeoncards where set = set
        $set = Onepieceset::where('url','=',$set)->first();

        return view('pages.onepieceneed')
        ->with('set',$set);
    }


    // character
    public function character($character_id) {
        // ok figuring out cards I need
        // have list of all the cards in the set, then have my list of cards in the set, so i can do one
        // of those sql things thats like exclude
        // so want all of pokmeoncards where set = set
        $character = Onepiececharacter::where('id','=',$character_id)->first();

        $cards = DB::table('onepiececards')
        ->where('character_id','=',$character_id)
        ->leftJoin('onepieceusercards', 'onepiececards.id', '=', 'onepieceusercards.onepiececard_id')
        ->get();

        return view('pages.onepieceset')
        ->with('set',$character)
        ->with('cards',$cards);
    }   
}
