<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Album;
use App\Models\Song;
use App\Models\Spotifyplay;

class MusicController extends Controller
{

    /**
     * Music overview
     *
     * @return \Illuminate\Http\Response
     */
    public function musicoverview(){
        $newsongs = Song::orderBy('id','desc')->take(10)->get();
        $lastten = Spotifyplay::orderBy('id','desc')->take(10)->get();
        $mostPlays = Song::orderBy('spotify_plays','desc')->take(10)->get();

        return  view('pages.musicoverview')
        ->with('newsongs',$newsongs)
        ->with('mostplays',$mostPlays)
        ->with('lastten',$lastten);
    }  

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
