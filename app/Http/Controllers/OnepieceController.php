<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Onepiececard;
use App\Models\Onepiececardhunt;
use App\Models\Onepiececardprice;
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
        ->select('onepiececards.*','onepieceusercards.*','onepiecesets.shortname as set_url','onepiecesets.imagename as set_imagename','onepiececards.id as onepiececardid')
        ->leftJoin('onepieceusercards', 'onepiececards.id', '=', 'onepieceusercards.onepiececard_id')
        ->leftJoin('onepiecesets','onepiececards.originaL_set_id','=','onepiecesets.id')
        ->get();

        return  view('pages.onepieceset')
        ->with('set',$setinfo)
        ->with('cards',$cards);
    }

    /**
     * Need - display cards needed in that set
     *
     * @return \Illuminate\Http\Response
     */
    public function need($set) {
        $set = Onepieceset::where('url','=',$set)->first();

        if ( !Auth::guest() ) {
            $usercards = Onepieceusercard::where('user_id','=',Auth::user()->id)->pluck('onepiececard_id')->toArray();
            $cards = Onepiececard::where('set_id','=',$set->id)->whereNotIn('id',$usercards)->get();
        } else {
            $cards = Onepiececard::where('set_id','=',$set->id)->get();
        }

        return view('pages.onepieceneed')
        ->with('cards',$cards)
        ->with('set',$set);
    }

        /**
     * Hunt - display cards in the hunt list
     *
     * @return \Illuminate\Http\Response
     */
    public function hunt() {
        if ( !Auth::guest() ) {
            // TODO: have it remove from hunt when added to db
            $userhunts = Onepiececardhunt::where('onepiececardhunts.user_id','=',Auth::user()->id)
                ->leftJoin('onepieceusercards','onepieceusercards.onepiececard_id','=','onepiececardhunts.onepiececard_id')
                ->whereNull('onepieceusercards.onepiececard_id')
                ->pluck('onepiececardhunts.onepiececard_id')->toArray();
            $cards = Onepiececard::whereIn('id',$userhunts)->get();
        } else {
            // this should just be moved to a user dashboard type thing
            $cards = Onepiececard::where('set_id','=',1)->get();
        }

        return view('pages.onepieceHunt')
        ->with('cards',$cards);
    }

    /**
     * Trends - price trends of the needed cards in that set
     *
     * @return \Illuminate\Http\Response
     */
    public function priceTrends($set) {
        $set = Onepieceset::where('url','=',$set)->first();

        if ( !Auth::guest() ) {
            $usercards = Onepieceusercard::where('user_id','=',Auth::user()->id)->pluck('onepiececard_id')->toArray();
            $cards = Onepiececard::where('set_id','=',$set->id)->whereNotIn('id',$usercards)->get();
        } else {
            $cards = Onepiececard::where('set_id','=',$set->id)->get();
        }

        foreach($cards as $card) {
            $prices = Onepiececardprice::where('onepiececard_id','=',$card->id)->orderBy('created_at','DESC')->limit(7)->pluck('price','created_at')->toArray();
            $keys = array_keys($prices);
            if (isset($keys[6])) {
                $difference = $prices[$keys[6]] - $prices[$keys[0]];
                if ($difference > 0) {
                    // the price is falling
                    $trend = 'falling';
                } else if ($difference < 0) {
                    $trend = 'rising';
                } else {
                    $trend = 'flat';
                }
            } else {
                $trend = 'nodata';
                $difference = 0;
            }

            $card->trend = $trend;
            $card->difference = round(abs($difference),2);
        }

        return view('pages.onepieceTrend')
        ->with('cards',$cards)
        ->with('set',$set);
    }

    // characters
    public function characters() {
        // ok figuring out cards I need
        // have list of all the cards in the set, then have my list of cards in the set, so i can do one
        // of those sql things thats like exclude
        // so want all of pokmeoncards where set = set
        $characters = Onepiececharacter::orderBy('name','ASC')->get();
        $favids = [2,15,13,1,4];
        $favs = Onepiececharacter::whereIn('id',$favids)->get();

        return view('pages.onepieceCharacters')
        ->with('favs',$favs)
        ->with('characters',$characters);
    }

    // character
    public function character($character_id) {
        // ok figuring out cards I need
        // have list of all the cards in the set, then have my list of cards in the set, so i can do one
        // of those sql things thats like exclude
        // so want all of pokmeoncards where set = set
        $character = Onepiececharacter::where('id','=',$character_id)->first();

        $cards = DB::table('onepiececards')
        ->where('character_id','=',$character->id)
        ->select('onepiececards.*','onepieceusercards.*','set.shortname as set_url',
                    'set.imagename as set_imagename','set.url as set_full_name','onepiececards.id as onepiececardid',
                    'original_set.shortname as original_set_url','original_set.imagename as original_set_imagename')
        ->leftJoin('onepieceusercards', 'onepiececards.id', '=', 'onepieceusercards.onepiececard_id')
        ->leftJoin('onepiecesets as set','onepiececards.set_id','=','set.id')
        ->leftJoin('onepiecesets as original_set','onepiececards.originaL_set_id','=','original_set.id')
        ->get();

        return view('pages.onepieceCharacter')
        ->with('character',$character)
        ->with('set',$character)
        ->with('cards',$cards);
    }

    /**
     * Add card  UI
     *
     * @return \Illuminate\Http\Response
     */
    public function addCardDisplay() {
        $sets = Onepieceset::orderBy('release_date','DESC')->pluck('shortname','id');
        $characters = Onepiececharacter::orderBy('name','ASC')->pluck('name','id');
        // last card
        $last = Onepiececard::orderBy('created_at','DESC')->pluck('set_number')->first();
        $next = $last + 1;
        $nextCard = str_pad( $next , 3 , '0', STR_PAD_LEFT );
        // last set
        $lastset = Onepiececard::orderBy('created_at','DESC')->pluck('set_id')->first();

        return view('dashboard.onepieceCardAdd')
            ->with('characters',$characters)
            ->with('lastset',$lastset)
            ->with('nextcard',$nextCard)
            ->with('sets',$sets);
} 

    /**
     * Add one piece card
     *
     * @return \Illuminate\Http\Response
     */
    public function addCard(Request $request) {

        $this->validate($request, [
            'name' => 'required',
        
        ]);

        $b = new Onepiececard;
        $b->name = $request->input('name');
        $b->set_id = $request->input('set_id');
        $b->set_number = $request->input('set_number');
        $b->card_number = $request->input('card_number');
        $b->character_id = $request->input('character_id');
        $b->rarity_id = 1;
        $b->original_set_id = $request->input('original_set_id');
        $b->original_set_number = $request->input('original_set_number');
        $b->tcgcsv_id =  0;
        $b->save();

        return redirect('/dashboard');          
    }

     /**
     * One piece card display
     *
     * @return \Illuminate\Http\Response
     */
    public function cardDisplay($set_url,$onepiececard_id) {
        $set = Onepieceset::where('url','=',$set_url)->first();
        $card = Onepiececard::where('id','=',$onepiececard_id)->first();

        if ($card->original_set_id != 0) {
            $originalSet = Onepieceset::where('id','=',$card->original_set_id)->first();
        } else {
            $originalSet = '';
        }


        // $cards = DB::table('onepiececards')
        // ->where('set_id','=',$setinfo->id)
        // ->select('onepiececards.*','onepieceusercards.*','onepiecesets.url as set_url','onepiecesets.imagename as set_imagename','onepiececards.id as onepiececardid')
        // ->leftJoin('onepieceusercards', 'onepiececards.id', '=', 'onepieceusercards.onepiececard_id')
        // ->leftJoin('onepiecesets','onepiececards.originaL_set_id','=','onepiecesets.id')
        // ->get();

        $prices = Onepiececardprice::where('onepiececard_id','=',$card->id)->orderBy('created_at','DESC')->get();



        // need to change if other users
        $usercards = Onepieceusercard::where('user_id','=',1)->where('onepiececard_id','=',$onepiececard_id)->get();
        return view('pages.onepieceCard')
            ->with('card',$card)
            ->with('prices',$prices)
            ->with('usercards',$usercards)
            ->with('set',$set)
            ->with('originalset',$originalSet);
    }  

    /**
     * Add one peice user card
     *
     * @return \Illuminate\Http\Response
     */
    public function addUserCard(Request $request) {
        $b = new Onepieceusercard;
        $b->user_id = $request->input('user_id');
        $b->onepiececard_id = $request->input('onepiececard_id');
        $b->price = 0.00;
        $b->source = '';
        $b->save();

        $url = Onepieceset::where('id','=',$request->input('set_id'))->first();


        return redirect('/onepiece/set/'.$url->url.'/#'.$request->input('onepiececard_id'));          
    }

    /**
     * Edit one piece user card
     *
     * @return \Illuminate\Http\Response
     */
    public function editUserCard(Request $request) {
        $usercard_id = $request->input('id');
        $set_url = $request->input('set_url');
        $onepiececard_id = $request->input('onepiececard_id');

        $up = Onepieceusercard::find($usercard_id);
        $up->price = $request->input('price');
        $up->source = $request->input('source');
        $up->date_acquired = $request->input('date_acquired');
        $up->save();
   
        return redirect('/onepiece/set/'.$set_url.'/'.$onepiececard_id);    
    }    

    /**
     * List cards for eiting
     *
     * @return \Illuminate\Http\Response
     */
    public function listCardDisplay() {
        $cards = Onepiececard::orderBy('created_at','DESC')->get();

        return view('dashboard.onepieceCardList')
        ->with('cards',$cards);
    }

    /**
     * UI for editing cards
     *
     * @return \Illuminate\Http\Response
     */
    public function editCardDisplay($card_id) {
        $card = Onepiececard::find($card_id);
        $set = Onepieceset::where('id','=',$card->set_id)->first();
        $sets = Onepieceset::orderBy('release_date','DESC')->pluck('name','id');
        $characters = Onepiececharacter::orderBy('name','ASC')->pluck('name','id');

        return view('dashboard.onepieceCardEdit')
        ->with('card',$card)
        ->with('set',$set)
        ->with('sets',$sets)
        ->with('characters',$characters);
    } 

    /**
     * Edit card
     *
     * @return \Illuminate\Http\Response
     */
    public function editCard(Request $request) {
        $card_id = $request->input('card_id');

        $up = Onepiececard::find($card_id);
        $up->name = $request->input('name');
        $up->set_id = $request->input('set_id');
        $up->set_number = $request->input('set_number');
        $up->card_number = $request->input('card_number');
        $up->character_id = $request->input('character_id');
        $up->original_set_id = $request->input('original_set_id');
        $up->original_set_number = $request->input('original_set_number');
        $up->tcgcsv_id =  $request->input('tcgcsv_id');
        $up->save();
   
        return redirect('/dashboard/onepiececard/edit/'.$card_id);       
    } 

    /**
     * Add one peice card hunt
     *
     * @return \Illuminate\Http\Response
     */
    public function addCardHunt(Request $request) {
        $b = new Onepiececardhunt;
        $b->user_id = $request->input('user_id');
        $b->onepiececard_id = $request->input('onepiececard_id');
        $b->save();

        $url = Onepieceset::where('id','=',$request->input('set_id'))->first();


        return redirect('/onepiece/set/'.$url->url.'/#'.$request->input('onepiececard_id'));          
    }


    /**
     * Add set  UI
     *
     * @return \Illuminate\Http\Response
     */
    public function addSetDisplay() {
        return view('dashboard.onepieceSetAdd');
    }    
    
    /**
     * Add one piece card set
     *
     * @return \Illuminate\Http\Response
     */
    public function addSet(Request $request) {

        $this->validate($request, [
            'name' => 'required',
        
        ]);

        $b = new Onepieceset;
        $b->name = $request->input('name');
        $b->url = $request->input('url');
        $b->release_date = $request->input('release_date');
        $b->shortname = $request->input('shortname');
        $b->imagename = $request->input('imagename');
        $b->save();

        return redirect('/dashboard');          
    }  
    
    /**
     * List sets for eiting
     *
     * @return \Illuminate\Http\Response
     */
    public function listSetDisplay() {
        $sets = Onepieceset::orderBy('release_date','DESC')->get();

        return view('dashboard.onepieceSetList')
        ->with('sets',$sets);
}

    /**
     * UI for editing sets
     *
     * @return \Illuminate\Http\Response
     */
    public function editSetDisplay($set_id) {
        $set = Onepieceset::find($set_id);

        return view('dashboard.onepieceSetEdit')
        ->with('set',$set);
} 

    /**
     * Edit set
     *
     * @return \Illuminate\Http\Response
     */
    public function editSet(Request $request) {
        $set_id = $request->input('set_id');

        $up = Onepieceset::find($set_id);
        $up->name = $request->input('name');
        $up->url = $request->input('url');
        $up->release_date = $request->input('release_date');
        $up->shortname = $request->input('shortname');
        $up->imagename = $request->input('imagename');
        $up->save();
   
        return redirect('/dashboard/onepieceset/edit/'.$set_id);       
    } 

    /**
     * Add character  UI
     *
     * @return \Illuminate\Http\Response
     */
    public function addCharacterDisplay() {
        return view('dashboard.onepieceCharacterAdd');
    }    
    
    /**
     * Add one piece character
     *
     * @return \Illuminate\Http\Response
     */
    public function addCharacter(Request $request) {

        $this->validate($request, [
            'name' => 'required',
        
        ]);

        $b = new Onepiececharacter;
        $b->name = $request->input('name');
        $b->save();

        return redirect('/dashboard');          
    }  

    /**
     * List characters for eiting
     *
     * @return \Illuminate\Http\Response
     */
    public function listCharacterDisplay() {
        $characters = Onepiececharacter::orderBy('created_at','DESC')->get();

        return view('dashboard.onepieceCharacterList')
        ->with('characters',$characters);
    }

    /**
     * UI for editing character
     *
     * @return \Illuminate\Http\Response
     */
    public function editCharacterDisplay($character_id) {
        $character = Onepiececharacter::find($character_id);

        return view('dashboard.onepieceCharacterEdit')
        ->with('character',$character);
    } 

    /**
     * Edit character
     *
     * @return \Illuminate\Http\Response
     */
    public function editCharacter(Request $request) {
        $character_id = $request->input('character_id');

        $up = Onepiececharacter::find($character_id);
        $up->name = $request->input('name');
        $up->save();
   
        return redirect('/dashboard/onepiececharacter/edit/'.$character_id);       
    } 

}
