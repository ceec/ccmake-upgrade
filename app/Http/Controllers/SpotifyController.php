<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use SpotifyWebAPI;
use App\Models\Spotifyplay;
use App\Models\Song;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Songartist;

class SpotifyController extends Controller {


 
    /**
    * spotify test
    *
    * @return \Illuminate\Http\Response
    */
   public function getListenedSongs(){

     $session = new SpotifyWebAPI\Session(
        config('custom.SPOTIFY_CLIENT_ID'),
        config('custom.SPOTIFY_CLIENT_SECRET'),
        config('custom.SPOTIFY_URL')
     );


     $api = new SpotifyWebAPI\SpotifyWebAPI();

     if (isset($_GET['code'])) {
         $session->requestAccessToken($_GET['code']);
         $api->setAccessToken($session->getAccessToken());

         // Need to build a separate tool to grab all from the beginning 

         // Then have a cron that checks it, hourly? 

         //$recent = $api->getMyRecentTracks(['limit' => 5]);
         // time is in miliseconds
         // before doesn't return stuff but after does
         // great looks like it only saves 15 days of data RIP MY DATA
         // its weirdly 50 songs, maybe it just remembers the last 50
         // okay i dont know the best way to cron it so just gona have it pull in last 20 and i can
         // run it manually

         $recent = $api->getMyRecentTracks(['limit' => 50]);  
         //$recent = $api->getMyRecentTracks(['after' => 1640382630000]);

         foreach ($recent->items as $track) {
             // Album info
             $info['album_name'] = $track->track->album->name;
             $info['album_tracks'] = $track->track->album->total_tracks;
             $info['album_id'] = $track->track->album->id;
             // Artist info - looks like its always an array?
             //$info['artist_id'] = $track->artists;
             // Played info
             $info['song_length'] = $track->track->duration_ms;
             $info['song_id'] = $track->track->id;
             $info['song_name'] = $track->track->name;

            // dd($track->track);

             $info['song_place'] = $track->track->track_number;
             // Actual played info
             $info['played_at'] = $track->played_at;

             // Check if this album is already in albums
             $albumcheck = Album::where('spotify_id','=',$info['album_id'])->first();


             if (!isset($albumcheck)) {
               // If its not there, add to albums
               $a = new Album;
               $a->name = $info['album_name'];
               $a->spotify_id = $info['album_id'];
               $a->save();

               $album_id = $a->id;
             } else {
               $album_id = $albumcheck->id;
             }

             // Check if this song is already in songs
             $songcheck = Song::where('spotify_id','=',$info['song_id'])->first();

             if (!isset($songcheck)) {
               // If its not there, add to songs
               $s = new Song;
               $s->name = $info['song_name'];
               //$s->artist_id = $artistcheck->id;
               $s->artist_id = 0;
               $s->album_id = $album_id;
               $s->track = $info['song_place'];
               $s->length = $info['song_length'];
               $s->spotify_plays = 1;
               $s->spotify_id = $info['song_id'];
               $s->save();

               $song_id = $s->id;
             } else {
               $song_id = $songcheck->id;

               // Increase the play count
               $play = $songcheck->spotify_plays + 1;
               $songcheck->spotify_plays = $play;
               $songcheck->save();

             }

             // Artists
             // Artists is always an array most just have one but can have more
             foreach($track->track->artists as $artist) {
               // Check if its there
               $artistcheck = Artist::where('spotify_id','=',$artist->id)->first();

               if (!isset($artistcheck)) {
                 // Create if its not there
                 $a = new Artist;
                 $a->name = $artist->name;
                 $a->spotify_id = $artist->id;
                 $a->save();

                 $artist_id = $a->id;
               } else {
                 $artist_id = $artistcheck->id;
               }

               // Need to add to the lookup table
               $lookupcheck = Songartist::where('song_id','=',$song_id)->where('artist_id','=',$artist_id)->first();
               if (!isset($lookupcheck)) {
                 $sa = new Songartist;
                 $sa->song_id = $song_id;
                 $sa->artist_id = $artist_id;
                 $sa->save();
               }
             }
             // Add to spotify play
             // Make sure its not already there
             // WHY NOT UTC
             date_default_timezone_set('UTC');
             $info['played_at'] = date('Y-m-d H:i:s',strtotime($info['played_at']));
             $playcheck = Spotifyplay::where('song_id','=',$info['song_id'])->where('played_at','=',$info['played_at'])->first();

             if (!isset($playcheck)) {
               $s = new Spotifyplay;
               $s->song_id = $info['song_id'];
               $s->played_at = $info['played_at'];
               $s->updated_by = 1;
               $s->save();
             }




             $data[] = $info;
         }

         
             print '<pre>';
             print_r($data);
             print '</pre>';
             print '<hr>';
     } else {
         $options = [
             'scope' => [
                 'user-read-email',
                 'user-read-recently-played'
             ],
         ];

         header('Location: ' . $session->getAuthorizeUrl($options));
         die();
     } 

   }
}