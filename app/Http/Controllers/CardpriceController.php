<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Onepiececard;
use App\Models\Onepiececardprice;
use App\Models\Onepieceset;
use App\Models\Onepieceusercard;
use App\Models\Onepiececharacter;
use App\Models\Pokemoncard;
use App\Models\Pokemoncardprice;
use App\Models\Pokemonset;
use GuzzleHttp\Client;

class CardpriceController extends Controller
{

    /**
     * Get the latest prices for wings of the captain cards
     *
     * @return \Illuminate\Http\Response
     */
    public function onepiecePriceData($tcgcsv_id){
        // get info on the set
        $client = new Client();
        $url = 'https://tcgcsv.com/tcgplayer/68/'.$tcgcsv_id.'/prices';

        try {
            $response = $client->request('GET', $url);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $jsonContent = $response->getBody()->getContents();
                $data = json_decode($jsonContent, false); // `true` for associative array, `false` for object

                $prices = $data->results;
                //loop through the data
                foreach( $prices as $price ) {
                    echo '<pre>';
                    print_r($price);
                    echo '</pre>';
                    echo '<hr>';
                    $card = Onepiececard::where('tcgcsv_id','=',$price->productId)->first();

                    if (isset($card->id)) {
                        $p = new Onepiececardprice;
                        $p->onepiececard_id = $card->id;
                        $p->price = $price->marketPrice ?? 0;
                        $p->save();
                    }
                }

            } else {
                // Handle non-200 status codes
                return response()->json(['error' => 'Failed to fetch data', 'status' => $statusCode], $statusCode);
            }
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            // Handle Guzzle exceptions (e.g., network errors, timeouts)
            return response()->json(['error' => 'Failed to connect to the URL', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * Add in the tcgcsv id
     *
     * @return \Illuminate\Http\Response
     */
    public function onepieceAddTcgcsvId($tcgcsv_id){
        // get info on the set
        $client = new Client();
        //$url = 'https://tcgcsv.com/tcgplayer/68/23272/products'; // OP-06 wings of the captain
        $url = 'https://tcgcsv.com/tcgplayer/68/'.$tcgcsv_id.'/products'; // EB-01 memorial collection

        try {
            $response = $client->request('GET', $url);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $jsonContent = $response->getBody()->getContents();

                $data = json_decode($jsonContent, false); // `true` for associative array, `false` for object

                $products = $data->results;
               
                //loop through the data
                foreach( $products as $product ) {
                    // Only cards have extended data
                    if (isset($product->extendedData[0])) {
                        $setId = $product->extendedData[1]->value;

                        $displayData['tcgcsv_id'] = $product->productId;
                        $displayData['name'] = $product->name;
                        $displayData['card_id'] = $product->extendedData[1]->value;
                        //Distinguish the alt arts
                        // Lets just add (Alternate Art) (Manga) and (SP) to their names
                        $displayData['isAlertnateArt'] = str_contains($displayData['name'],'(Alternate Art)');
                        $displayData['isManga'] = str_contains($displayData['name'],'(Alternate Art) (Manga)');
                        $displayData['isSP'] = str_contains($displayData['name'],'(SP)');

                        echo '<pre>';
                        print_r($displayData);
                        echo '</pre>';
                        echo '<hr>';

                        if (isset($setId)) {
                            // Look up the id
                            $cardId = explode('-',$setId);

                            //$displayData['set'] = $cardId[0];
                            //$displayData['cardNumber'] = $cardId[1];

                           // print_r($displayData);
                            $set = Onepieceset::where('imagename','=',$cardId[0])->first();

                            if (isset($set->id)) {
                                // Handling multiple cards
                                // tcgcsv has data organized by
                                // Kouzuki Momonosuke
                                // Kouzuki Momonosuke (Alternate Art)
                                // but then when there are multiple cards 
                                // Hody Jones (020)
                                // Hody Jones (020) (Alternate Art)
                                // lets just update the names

                                // okay issue with prbs, names are the same as the original for the alt arts
                                // PRB-01:23496
                                // Maybe I should tie the tcgcsv to the set like in pokemon
                                if ($tcgcsv_id == '23496') {
                                    
                                    $actualset = Onepieceset::where('shortname','=','PRB-01')->first();
                                    // where set_id=10 AND original_set_id=1 AND original_set_number = 024
                                    $card = Onepiececard::where('set_id','=',$actualset->id)->where('original_set_id','=',$set->id)
                                        ->where('original_set_number','=',$cardId[1])
                                        ->where('name','=',$displayData['name'])->first();
                                } else {
                                    $card = Onepiececard::where('set_id','=',$set->id)->where('set_number','=',$cardId[1])
                                        ->where('name','=',$displayData['name'])->first();
                                }
                                

                                if ( isset($card->id) ) {
                                    // Don't update if one's already there
                                    if ($card->tcgcsv_id == 0) {
                                        echo 'Adding tcgcsv_id: '. $product->productId.' for: '. $card->name. ' id: '.$card->id;
                                        echo '<hr>';

                                        $up = Onepiececard::find($card->id);
                                        $up->tcgcsv_id = $product->productId;
                                        $up->save();

                                    } else {
                                        echo 'Already there tcgcsv_id: '. $product->productId.' for: '. $card->name. ' id: '.$card->id;
                                        echo '<hr>'; 
                                    }

                                } 
                            }
                        }


                    }
                }

            } else {
                // Handle non-200 status codes
                return response()->json(['error' => 'Failed to fetch data', 'status' => $statusCode], $statusCode);
            }
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            // Handle Guzzle exceptions (e.g., network errors, timeouts)
            return response()->json(['error' => 'Failed to connect to the URL', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Add in the tcgcsv id for pokemon
     *
     * @return \Illuminate\Http\Response
     */
    public function pokemonAddTcgcsvId($tcgcsv_set_id){
        // get info on the set
        $client = new Client();
        //pokeurl
        // base set - https://tcgcsv.com/tcgplayer/3/604/products
        $url = 'https://tcgcsv.com/tcgplayer/3/'.$tcgcsv_set_id.'/products'; // 604 - base set 

        try {
            $response = $client->request('GET', $url);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $jsonContent = $response->getBody()->getContents();

                $data = json_decode($jsonContent, false); // `true` for associative array, `false` for object

                $products = $data->results;
               
                //loop through the data
                foreach( $products as $product ) {
                    // Only cards have extended data
                    if (isset($product->extendedData[0]) && $product->extendedData[0]->name == 'Number' ) {

                        $displayData['tcgcsv_id'] = $product->productId;
                        $displayData['name'] = $product->name;
                        $displayData['number'] = $product->extendedData[0]->value;
                        $displayData['rarity'] = $product->extendedData[1]->value;

                        // echo '<pre>';
                        // print_r($displayData);
                        // echo '</pre>';
                        // echo '<hr>';

                        if (isset($displayData['number'])) {
                            
                            // Look up the id
                            $number = explode('/',$displayData['number']);

                            $displayData['raw_card_number'] = $number[0];
                            $displayData['card_number'] = (int) $number[0];
                            //$displayData['total'] = $number[1];

                            echo '<pre>';
                            print_r($displayData);
                            echo '</pre>';
                            echo '<hr>';

                            $set = Pokemonset::where('tcgcsv_id','=',$tcgcsv_set_id)->first();

                            if (isset($set->id)) {
                                // Handling multiple cards
                                $card = Pokemoncard::where('set_id','=',$set->id)->where('set_number','=',$displayData['card_number'])
                                        ->first();
                                       
                                        // echo '<pre>';
                                        // print_r($card);
                                        // echo '</pre>';

                            
                                //if ( isset($card->id) && ( $card->tcgcsv_id == 0 ) ) {
                                if ( isset($card->id)  ) {
                                    echo 'Adding tcgcsv_id: '. $product->productId.' for: '. $card->name. ' id: '.$card->id;
                                    echo '<hr>';

                                     $up = Pokemoncard::find($card->id);
                                     $up->tcgcsv_id = $product->productId;
                                     $up->save();

                                }
                            }
                        }


                    }
                }

            } else {
                // Handle non-200 status codes
                return response()->json(['error' => 'Failed to fetch data', 'status' => $statusCode], $statusCode);
            }
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            // Handle Guzzle exceptions (e.g., network errors, timeouts)
            return response()->json(['error' => 'Failed to connect to the URL', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get the latest prices for pokemon cards
     *
     * @return \Illuminate\Http\Response
     */
    public function pokemonPriceData($tcgcsv_id){
        // get info on the set
        $client = new Client();
        $url = 'https://tcgcsv.com/tcgplayer/3/'.$tcgcsv_id.'/prices';

        try {
            $response = $client->request('GET', $url);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $jsonContent = $response->getBody()->getContents();
                $data = json_decode($jsonContent, false); // `true` for associative array, `false` for object

                $prices = $data->results;
                //loop through the data
                foreach( $prices as $price ) {
                    echo '<pre>';
                    print_r($price);
                    echo '</pre>';
                    echo '<hr>';
                    $card = Pokemoncard::where('tcgcsv_id','=',$price->productId)->first();

                    //need to ignore reverse holos
                    // and first edition
                    if ($price->subTypeName != 'Reverse Holofoil' && $price->subTypeName != '1st Edition Holofoil' && $price->subTypeName != '1st Edition') {
                        echo '<br>'.$price->subTypeName;
                        if (isset($card->id) && isset($price->marketPrice) ) {
                            $p = new Pokemoncardprice;
                            $p->pokemoncard_id = $card->id;
                            $p->price = $price->marketPrice;
                            $p->save();
                        }
                    }



                }

            } else {
                // Handle non-200 status codes
                return response()->json(['error' => 'Failed to fetch data', 'status' => $statusCode], $statusCode);
            }
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            // Handle Guzzle exceptions (e.g., network errors, timeouts)
            return response()->json(['error' => 'Failed to connect to the URL', 'message' => $e->getMessage()], 500);
        }
    }


}
