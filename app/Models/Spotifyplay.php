<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Songartist;

class Spotifyplay extends Model {
    use HasFactory;

    public function findArtist() {
        // copied from song lets make this not be duplicated
        $songartist = SongArtist::where('song_id','=',$this->song_id)->get();

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

        return $artist;
    }

    public function songName() {
        $name = Song::where('spotify_id','=',$this->song_id)->value('name');

        return $name;
    }
}
