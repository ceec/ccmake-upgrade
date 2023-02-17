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
Route::get('/projects','App\Http\Controllers\PageController@projects');
Route::get('/pokemon','App\Http\Controllers\PageController@pokemoncards');
Route::get('/resources','App\Http\Controllers\PageController@resources');
// this is a different database for some reason? lets just combine it
Route::get('/time','App\Http\Controllers\PageController@time');
Route::get('/wordcount','App\Http\Controllers\PageController@wordcount');

//into the pokemoncard database
Route::get('/pokemon/set/{set}','App\Http\Controllers\PokemonController@set');
Route::get('/pokemon/card/{card}','App\Http\Controllers\PokemonController@card');

// music
Route::get('/music','App\Http\Controllers\MusicController@music');
Route::get('/music/album/{album}','App\Http\Controllers\MusicController@album');