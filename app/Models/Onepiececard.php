<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Onepiececard extends Model
{
    use HasFactory;

    /**
     * find the user that has this card? maybe?
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Pokemonusercard::class);
    }    

    public function originalSetUrl() {
        // $setName = Onepieceset:: where('id','=',$this->original_set_id)->get();

        // return $setName->url;

        return 'test';
    }

    // Get the last price
    public function lastPrice() {
        $price = Onepiececardprice::where('onepiececard_id','=',$this->id)->orderBy('created_at','DESC')->pluck('price')->first();
        return $price;
    }    

}
