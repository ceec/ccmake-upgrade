<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Songartist;
use App\Models\Album;


class Song extends Model
{
    use HasFactory;

    public function artist() {
        return $this->belongsTo('App\Models\Artist');
    }

    public function album() {
        return $this->belongsTo('App\Models\Album');
    }  

    public function findartist() {
        // mix of spotify and non spotify stuff
        // old non spotify stuff will have the artist_id right on the song
        // spotfity has them in the lookup table songartists
        // TODO: convert them all to spotiy style cause songs do have multiple artists

        if ($this->artist_id === 0) {
            // lets check spotify id 
        //..dd($this);
            $songartist = SongArtist::where('song_id','=',$this->id)->get();

            if ($songartist->isNotEmpty()) {
                $artists = '';
                foreach($songartist as $thisartist) {

                    $artist = Artist::where('id','=',$thisartist->artist_id)->first();
                    $artists .= $artist->name.' ';
                }
                $artist = $artists;
            } else {
                $artist = 'what';
            }


        } else {
            $artist = '';
        }


        return $artist;
    }

    public function spotifyplays() {
        // get a count from the spotifyplays table
        if ($this->artist_id === 0) {
            $plays = Spotifyplay::where('song_id','=',$this->spotify_id)->count();
            
        } else {
            $plays = 0;
        }
        return $plays;
    }

}
