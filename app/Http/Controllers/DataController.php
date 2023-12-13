<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\County;
use App\Models\Projectstep;
use App\Models\Wordcount;

class DataController extends Controller {

    ///travel
     /**
     * counites
     *
     * @return \Illuminate\Http\Response
     */
    public function counties(){

        $counties = County::select('code','county')->get();

        // foreach($counties as $key => $county) {
        //     var_dump($county->id);
        //     $counties[$key]['id'] = (string) $county->id;
        // }
        // print '<pre>';
        // print_r($counties);
        // print '</pre>';

        echo json_encode($counties);
    }


    //writing
     /**
     * words
     *
     * @return \Illuminate\Http\Response
     */
    public function words(){

        $words = Wordcount::where('updated_at','!=','0000-00-00 00:00:00')->get();


        // foreach ($words as $key => $word) {
        //     //remove time
        //     $word->updated = date('Y-m-d',strtotime($word->updated_at));
        //     if ($key == 'text') {
        //         unset($words[$key]);
        //     }
            
        // }
        foreach ($words as $word) {
            //remove time
            $word->updated = date('Y-m-d',strtotime($word->updated_at));
        }

        echo json_encode($words);
    }

    
     /**
     * project grids
     *
     * @return \Illuminate\Http\Response
     */
    public function grid($project_id){

        $days = Projectstep::where('project_id','=',$project_id)->orderBy('updated_at','DESC')->get();


        foreach ($days as $day) {
            //remove time
            $day->updated = date('Y-m-d',strtotime($day->completed_at));
        }


        echo json_encode($days);
    }

}