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
use GuzzleHttp\Client;

class CardpriceController extends Controller
{

    /**
     * Get the latest prices for wings of the captain cards
     *
     * @return \Illuminate\Http\Response
     */
    public function onepiecePriceData(){
        // get info on the set
        $client = new Client();
        $url = 'https://tcgcsv.com/tcgplayer/68/23272/prices';

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
                        $p->price = $price->marketPrice;
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
    public function onepieceAddTcgcsvId(){
        // get info on the set
        $client = new Client();
        //$url = 'https://tcgcsv.com/tcgplayer/68/23272/products'; // OP-06 wings of the captain
        $url = 'https://tcgcsv.com/tcgplayer/68/23333/products'; // EB-01 memorial collection

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
                                $card = Onepiececard::where('set_id','=',$set->id)->where('set_number','=',$cardId[1])
                                        ->where('name','=',$displayData['name'])->first();
                                       
                                        // echo '<pre>';
                                        // print_r($card);
                                        // echo '</pre>';

                            
                                //if ( isset($card->id) && ( $card->tcgcsv_id == 0 ) ) {
                                if ( isset($card->id)  ) {
                                    echo 'Adding tcgcsv_id: '. $product->productId.' for: '. $card->name. ' id: '.$card->id;
                                    echo '<hr>';

                                    $up = Onepiececard::find($card->id);
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

}
