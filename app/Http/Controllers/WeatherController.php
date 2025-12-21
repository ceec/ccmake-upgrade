<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Weather;

class WeatherController extends Controller {

     /**
     * Get Data from Tempest
     *
     * @return \Illuminate\Http\Response
     */
    public function getData() {

        // Grab data from the url
        // My station id 19456
        // https://swd.weatherflow.com/swd/rest/observations/station/19456?api_key=20c70eae-e62f-4d3b-b3a4-8586e90f3ac8
  
        // There is 1000 better ways to do this?
        $rawdata = file_get_contents('https://swd.weatherflow.com/swd/rest/observations/station/19456?api_key=6aed2471-e0ef-4e69-9adc-f375d5eee812');
  
        // Parse the data
        $data = json_decode($rawdata, true);
  
        // Calculate the wind direction from degrees
  
        $winddegree = $data['obs'][0]['wind_direction'];
        $direction = ($winddegree % 360);
        $direction = round($direction / 22.5);
       
        $directions = ["N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW","N"];
  
        $direction =  $directions[$direction];
  
  
        // Insert into the Weather table
        $w = new Weather;
  
        foreach($data['obs'][0] as $key => $value) {
          $w->$key = $value;
        }
        $w->cardinal_direction = $direction;
        $w->save();
  
  
      }


      public function showMileaBeach() {
        $weather = Weather::orderBy('created_at','desc')->first();

        return  view('pages.mileaBeach')
        ->with('weather',$weather);
      }

      // lul getting data from myself
      public function getLatestData() {
        $weather = Weather::orderBy('created_at','desc')->first();

        echo $weather;
      }

}
