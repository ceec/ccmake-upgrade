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
Route::get('/movies','App\Http\Controllers\PageController@movies');
Route::get('/pokemon','App\Http\Controllers\PageController@pokemoncards');

//into the pokemoncard database
Route::get('/pokemon/set/{set}','App\Http\Controllers\PokemonController@set');
Route::get('/pokemon/card/{card}','App\Http\Controllers\PokemonController@card');


Route::get('/chelsea','PageController@chelsea');
Route::get('/manga','PageController@manga');
Route::get('/counties','PageController@counties');
Route::get('/projects','PageController@projects');

Route::get('/wordcount','PageController@wordcount');
Route::get('/resources','PageController@resources');
Route::get('/bookshelf','PageController@bookshelf');
Route::get('/time','PageController@time');
Route::get('/music','PageController@music');