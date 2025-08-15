<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'App\Http\Controllers\PageController@index');

///everything is a link!
Route::get('/category/{category}','App\Http\Controllers\PageController@category');
Route::get('/project/{project}','App\Http\Controllers\PageController@project');
Route::get('/tag/{tag}','PageController@tag');
Route::get('/tool/{tool}','PageController@tool');


//specific pages
Route::get('/bookshelf','App\Http\Controllers\PageController@bookshelf');
Route::get('/counties','App\Http\Controllers\PageController@counties');
Route::get('/chelsea','App\Http\Controllers\PageController@chelsea');
Route::get('/manga','App\Http\Controllers\PageController@manga');
Route::get('/movies','App\Http\Controllers\PageController@movies');
Route::get('/pokemon','App\Http\Controllers\PageController@pokemoncards');
Route::get('/resources','App\Http\Controllers\PageController@resources');
// this is a different database for some reason? lets just combine it
Route::get('/time','App\Http\Controllers\PageController@time');
Route::get('/wordcount','App\Http\Controllers\PageController@wordcount');
Route::get('/onepiece','App\Http\Controllers\PageController@onepiece');

// projects
Route::get('/projects','App\Http\Controllers\PageController@projects');
Route::get('/projects/all','App\Http\Controllers\PageController@projectsAll');


//into the pokemoncard database
Route::get('/pokemon/card/{card}','App\Http\Controllers\PokemonController@card');
Route::get('/pokemon/need/{set}','App\Http\Controllers\PokemonController@need');
Route::get('/pokemon/set/{set}','App\Http\Controllers\PokemonController@set');

// one piece card database
Route::get('/onepiece/card/{card}','App\Http\Controllers\OnepieceController@card');
Route::get('/onepiece/need/{set}','App\Http\Controllers\OnepieceController@need');
Route::get('/onepiece/set/{set}','App\Http\Controllers\OnepieceController@set');
Route::get('/onepiece/character/{character}','App\Http\Controllers\OnepieceController@character');

// music
Route::get('/music2','App\Http\Controllers\MusicController@music');
Route::get('/music','App\Http\Controllers\MusicController@musicoverview');
Route::get('/music/album/{album}','App\Http\Controllers\MusicController@album');

//rocks - okay this is in a different db too? Or i dont have it locally
Route::get('/rocks', 'App\Http\Controllers\PageController@rocks');
Route::get('rocks/{mineral_name}', 'App\Http\Controllers\PageController@showMinerals');

// Books
Route::get('/books','App\Http\Controllers\BookController@books');
Route::get('/books/group/{group}','App\Http\Controllers\BookController@groups');
Route::get('/books/type/{type}','App\Http\Controllers\BookController@types');

///data!
Route::get('/data/counties','App\Http\Controllers\DataController@counties');
Route::get('/data/words','App\Http\Controllers\DataController@words');
Route::get('/data/grid/{project_id}','App\Http\Controllers\DataController@grid');

// spotify
Route::get('/spotify','App\Http\Controllers\SpotifyController@getListenedSongs');

// attempting authentication

Route::get('/dashboard','App\Http\Controllers\HomeController@dashboard', function () {
    // ...
})->middleware(['verified']);

// Blog
Route::get('/dashboard/blog/add','App\Http\Controllers\BlogController@addDisplay', function () {})->middleware(['verified']);

//add edit blog
// Route::get('/home/blog/add','BlogController@addDisplay');
// Route::get('/home/blog/edit/{blog_id}','BlogController@editDisplay');
// Route::get('/home/blog/list','BlogController@listDisplay');
// //posting
// Route::post('/add/blog','BlogController@add');
// Route::post('/edit/blog','BlogController@edit');