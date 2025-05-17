<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Onepieceset extends Model
{
    use HasFactory;

    // get all the cards in the set
    public function cards(): HasMany {
        return $this->hasMany(Onepiececard::class, 'set_id', 'id');
    }

    public function cardsneeded() {
        $cards = Onepiececard::where('set_id','=',$this->id)->get();

        // WOO it works, get all the cards I dont have in the set
        $cards = DB::table('onepiececards')
        ->where('set_id','=',$this->id)
        ->whereNotIn('id',DB::table('onepiececards')->where('set_id','=',$this->id)->join('onepieceusercards', 'onepiececards.id', '=', 'onepieceusercards.onepiececard_id')->pluck('onepiececards.id'))
        ->select('onepiececards.*','onepieceusercards.*','onepiecesets.url as set_url','onepiecesets.imagename as set_imagename')
        ->leftJoin('onepieceusercards', 'onepiececards.id', '=', 'onepieceusercards.onepiececard_id')
        ->leftJoin('onepiecesets','onepiececards.originaL_set_id','=','onepiecesets.id')
        ->get();

        return $cards;
    }

    public function totalcards() {
        $cards = Onepiececard::where('set_id','=',$this->id)->get();
        $total = $cards->count();

        return $total;
    }

    public function totalhavecards() {
        $cards = DB::table('onepiececards')
        ->where('set_id','=',$this->id)
        ->whereIn('id',DB::table('onepiececards')->where('set_id','=',$this->id)->join('onepieceusercards', 'onepiececards.id', '=', 'onepieceusercards.onepiececard_id')->pluck('onepiececards.id'))
        ->get();       
        
        $total = $cards->count();

        return $total;
    } 
    
    public function totalneedcards() {
        $cards = DB::table('onepiececards')
        ->where('set_id','=',$this->id)
        ->whereNotIn('id',DB::table('onepiececards')->where('set_id','=',$this->id)->join('onepieceusercards', 'onepiececards.id', '=', 'onepieceusercards.onepiececard_id')->pluck('onepiececards.id'))
        ->get();       
        
        $total = $cards->count();

        return $total;
    }      

    // Return the set number for images, no dash
    public function imageNumber() {

        return str_replace('-','',$this->shortname);
    }
}
