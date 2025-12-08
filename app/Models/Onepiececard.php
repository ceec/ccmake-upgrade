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

    // Get the last weeks price fluxuation
    public function priceTrend() {
        $prices = Onepiececardprice::where('onepiececard_id','=',$this->id)->orderBy('created_at','DESC')->limit(7)->pluck('price','created_at')->toArray();
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

        $difference = round(abs($difference),2);
        $priceDisplay = '<span class="'.$trend.'">'.$difference.'</span>';
        return $priceDisplay;
    }

    public function getSetShortname() {
        $set = Onepieceset::where('id','=',$this->set_id);

        return $set->imagename;
    }

    public function set(): BelongsTo {
        return $this->belongsTo(Onepieceset::class);
    }

    public function original_set(): BelongsTo {
        return $this->belongsTo(Onepieceset::class);
    }   

    public function character(): BelongsTo {
        return $this->belongsTo(Onepiececharacter::class);
    }

}
