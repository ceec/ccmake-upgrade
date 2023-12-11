<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Album;
use App\Models\Song;

class MusicController extends Controller
{

    /**
     * All music
     *
     * @return \Illuminate\Http\Response
     */
    public function music(){
        $songs = Song::take(10)->get();

        return  view('pages.music')
        ->with('songs',$songs);
    }     

    /**
     * Music - albums
     *
     * @return \Illuminate\Http\Response
     */
    public function album($album_id){
        $album = Album::where('id','=',$album_id)->first();

        $songs = Song::where('album_id','=',$album_id)->get();

        return  view('pages.album')
        ->with('album',$album)
        ->with('songs',$songs);
    } 
}
