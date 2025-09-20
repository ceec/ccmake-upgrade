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
        // $cards = DB::table('pokemoncards')
        // ->where('set_id','=',$setinfo->id)
        // ->leftJoin('pokemonusercards', 'pokemoncards.id', '=', 'pokemonusercards.pokemoncard_id')
        // ->get();

        $cards = DB::table('pokemoncards')
        ->where('set_id','=',$setinfo->id)
        ->select('pokemoncards.*','pokemonusercards.*','pokemoncards.id as pokemoncardid')
        ->leftJoin('pokemonusercards', 'pokemoncards.id', '=', 'pokemonusercards.pokemoncard_id')
        ->get();



        return  view('pages.pokemonset')
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
        $set = Pokemonset::where('url','=',$set)->first();

        return view('pages.pokemonneed')
        ->with('set',$set);
    }

    /**
     * Add card  UI
     *
     * @return \Illuminate\Http\Response
     */
    public function addCardDisplay() {
        $sets = Pokemonset::orderBy('release_date','DESC')->pluck('name','id');
        // last card
        $last = Pokemoncard::orderBy('created_at','DESC')->pluck('set_number')->first();
        $nextCard = $last + 1;
        // last set
        $lastset = Pokemoncard::orderBy('created_at','DESC')->pluck('set_id')->first();

        return view('dashboard.pokemonCardAdd')
            ->with('lastset',$lastset)
            ->with('nextcard',$nextCard)
            ->with('sets',$sets);
} 

    /**
     * Add pokemon card
     *
     * @return \Illuminate\Http\Response
     */
    public function addCard(Request $request) {

        $this->validate($request, [
            'name' => 'required',
        
        ]);

        $b = new Pokemoncard;
        $b->name = $request->input('name');
        $b->set_id = $request->input('set_id');
        $b->set_number = $request->input('set_number');
        $b->pokemon_id = 0;
        $b->rarity_id = 0;
        $b->save();

        return redirect('/dashboard/pokemoncard/add');          
    }

     /**
     * Pokemon card display
     *
     * @return \Illuminate\Http\Response
     */
    public function cardDisplay($set_url,$pokemoncard_id) {
        $set = Pokemonset::where('url','=',$set_url)->orderBy('release_date','DESC')->first();
        $card = Pokemoncard::where('id','=',$pokemoncard_id)->first();
        // need to change if other users
        $usercards = Pokemonusercard::where('user_id','=',1)->where('pokemoncard_id','=',$pokemoncard_id)->get();
        return view('pages.pokemonCard')
            ->with('card',$card)
            ->with('usercards',$usercards)
            ->with('set',$set);
    }    

    /**
     * Add pokemon user card
     *
     * @return \Illuminate\Http\Response
     */
    public function addUserCard(Request $request) {
        $b = new Pokemonusercard;
        $b->user_id = $request->input('user_id');
        $b->pokemoncard_id = $request->input('pokemoncard_id');
        $b->price = 0.00;
        $b->source = '';
        $b->save();

        $url = Pokemonset::where('id','=',$request->input('set_id'))->first();


        return redirect('/pokemon/set/'.$url->url.'/#'.$request->input('pokemoncard_id'));          
    }

    /**
     * Edit pokemon user card
     *
     * @return \Illuminate\Http\Response
     */
    public function editUserCard(Request $request) {
        $usercard_id = $request->input('id');
        $set_url = $request->input('set_url');
        $pokemoncard_id = $request->input('pokemoncard_id');

        $up = Pokemonusercard::find($usercard_id);
        $up->price = $request->input('price');
        $up->source = $request->input('source');
        $up->date_acquired = $request->input('date_acquired');
        $up->save();
   
        return redirect('/pokemon/set/'.$set_url.'/'.$pokemoncard_id);    
    }

    /**
     * Add set  UI
     *
     * @return \Illuminate\Http\Response
     */
    public function addSetDisplay() {
        return view('dashboard.pokemonSetAdd');
    }    

    /**
     * Add pokemon card set
     *
     * @return \Illuminate\Http\Response
     */
    public function addSet(Request $request) {

        $this->validate($request, [
            'name' => 'required',
        
        ]);

        $b = new Pokemonset;
        $b->name = $request->input('name');
        $b->url = $request->input('url');
        $b->release_date = $request->input('release_date');
        $b->generation_id = 0;
        $b->save();

        return redirect('/dashboard');          
    }  

    /**
     * List sets for eiting
     *
     * @return \Illuminate\Http\Response
     */
    public function listSetDisplay() {
        $sets = Pokemonset::orderBy('release_date','DESC')->get();

        return view('dashboard.pokemonSetList')
        ->with('sets',$sets);
}

    /**
     * UI for editing sets
     *
     * @return \Illuminate\Http\Response
     */
    public function editSetDisplay($set_id) {
        $set = Pokemonset::find($set_id);

        return view('dashboard.pokemonSetEdit')
        ->with('set',$set);
} 

    /**
     * Edit set
     *
     * @return \Illuminate\Http\Response
     */
    public function editSet(Request $request) {
        $set_id = $request->input('set_id');

        $up = Pokemonset::find($set_id);
        $up->name = $request->input('name');
        $up->url = $request->input('url');
        $up->release_date = $request->input('release_date');
        $up->generation_id = $request->input('generation_id');
        $up->save();
   
        return redirect('/dashboard/pokemonset/edit/'.$set_id);       
    } 

}
