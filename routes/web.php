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
Route::get('/tag/{tag}','App\Http\Controllers\PageController@tag');
Route::get('/tool/{tool}','App\Http\Controllers\PageController@tool');


//specific pages
Route::get('/bookshelf','App\Http\Controllers\PageController@bookshelf');
Route::get('/counties','App\Http\Controllers\PageController@counties');
Route::get('/chelsea','App\Http\Controllers\PageController@chelsea');
Route::get('/manga','App\Http\Controllers\PageController@manga');
Route::get('/movies','App\Http\Controllers\PageController@movies');
Route::get('/resources','App\Http\Controllers\PageController@resources');
// this is a different database for some reason? lets just combine it
Route::get('/time','App\Http\Controllers\PageController@time');
Route::get('/wordcount','App\Http\Controllers\PageController@wordcount');
Route::get('/onepiece','App\Http\Controllers\PageController@onepiece');

// projects
Route::get('/projects','App\Http\Controllers\PageController@projects');
Route::get('/projects/all','App\Http\Controllers\PageController@projectsAll');

// pokemon
Route::get('/pokemon','App\Http\Controllers\PageController@pokemoncardsBySet');
Route::get('/pokemon/all','App\Http\Controllers\PageController@pokemoncards');


//into the pokemoncard database
// Set specific card view
Route::get('/pokemon/card/{card}','App\Http\Controllers\PokemonController@card');
Route::get('/pokemon/need/{set}','App\Http\Controllers\PokemonController@need');
Route::get('/pokemon/set/{set}','App\Http\Controllers\PokemonController@set');
Route::get('/pokemon/set/{set_name}/{card_id}','App\Http\Controllers\PokemonController@cardDisplay');



// one piece card database
Route::get('/onepiece/card/{card}','App\Http\Controllers\OnepieceController@card');
Route::get('/onepiece/need/{set}','App\Http\Controllers\OnepieceController@need');
Route::get('/onepiece/set/{set}','App\Http\Controllers\OnepieceController@set');
Route::get('/onepiece/set/{set_name}/{card_id}','App\Http\Controllers\OnepieceController@cardDisplay');
Route::get('/onepiece/characters','App\Http\Controllers\OnepieceController@characters');
Route::get('/onepiece/character/{character}','App\Http\Controllers\OnepieceController@character');
Route::get('/onepiece/trends/{set}','App\Http\Controllers\OnepieceController@priceTrends');
Route::get('/onepiece/hunt','App\Http\Controllers\OnepieceController@hunt');
Route::get('/onepiece/pricechanges','App\Http\Controllers\OnepieceController@pricechanges');

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

// Card Data
// limiting to one piece first
Route::get('/onepiece/pricedata/{tcgid}','App\Http\Controllers\CardpriceController@onepiecePriceData');
Route::get('/onepiece/addTcgcsvIds/{tcgid}','App\Http\Controllers\CardpriceController@onepieceAddTcgcsvId');
Route::get('/onepiece/updateTcgplayerprices','App\Http\Controllers\CardpriceController@onepieceUpdateTcgPlayerprices');


//lets do some pokedata!
Route::get('/pokemon/addTcgcsvIds/{tcgid_set_id}','App\Http\Controllers\CardpriceController@pokemonAddTcgcsvId');
Route::get('/pokemon/pricedata/{tcgid}','App\Http\Controllers\CardpriceController@pokemonPriceData');

// Weather data
Route::get('/weather/getdata','App\Http\Controllers\WeatherController@getData');
Route::get('/weather/getlatestdata','App\Http\Controllers\WeatherController@getLatestData');
// mileabeach
Route::get('/weather/mileabeach','App\Http\Controllers\WeatherController@showMileaBeach');


// attempting authentication
Route::get('/dashboard','App\Http\Controllers\DashboardController@index', function () {})->middleware(['verified']);

// Route::get('/dashboard','App\Http\Controllers\DashboardController@dashboard', function () {
//     // ...
// })->middleware(['verified']);

// Blog
Route::get('/dashboard/blog/add','App\Http\Controllers\BlogController@addDisplay', function () {})->middleware(['verified']);
Route::get('/dashboard/blog/list','App\Http\Controllers\BlogController@listDisplay', function () {})->middleware(['verified']);
Route::get('/dashboard/blog/edit/{blog_id}','App\Http\Controllers\BlogController@editDisplay', function () {})->middleware(['verified']);
//posting
Route::post('/add/blog','App\Http\Controllers\BlogController@add', function () {})->middleware(['verified']);
Route::post('/edit/blog','App\Http\Controllers\BlogController@edit', function () {})->middleware(['verified']);

// One Piece
// One Piece Cards
Route::get('/dashboard/onepiececard/add','App\Http\Controllers\OnepieceController@addCardDisplay', function () {})->middleware(['verified']);
Route::get('/dashboard/onepiececard/list','App\Http\Controllers\OnepieceController@listCardDisplay', function () {})->middleware(['verified']);
Route::get('/dashboard/onepiececard/edit/{card_id}','App\Http\Controllers\OnepieceController@editCardDisplay', function () {})->middleware(['verified']);
//posting
Route::post('/add/onepiececard','App\Http\Controllers\OnepieceController@addCard', function () {})->middleware(['verified']);
Route::post('/edit/onepiececard','App\Http\Controllers\OnepieceController@editCard', function () {})->middleware(['verified']);

// One Piece Card sets
Route::get('/dashboard/onepieceset/add','App\Http\Controllers\OnepieceController@addSetDisplay', function () {})->middleware(['verified']);
Route::get('/dashboard/onepieceset/list','App\Http\Controllers\OnepieceController@listSetDisplay', function () {})->middleware(['verified']);
Route::get('/dashboard/onepieceset/edit/{card_id}','App\Http\Controllers\OnepieceController@editSetDisplay', function () {})->middleware(['verified']);
//posting
Route::post('/add/onepieceset','App\Http\Controllers\OnepieceController@addSet', function () {})->middleware(['verified']);
Route::post('/edit/onepieceset','App\Http\Controllers\OnepieceController@editSet', function () {})->middleware(['verified']);

// One Piece Characters
Route::get('/dashboard/onepiececharacter/add','App\Http\Controllers\OnepieceController@addCharacterDisplay', function () {})->middleware(['verified']);
Route::get('/dashboard/onepiececharacter/list','App\Http\Controllers\OnepieceController@listCharacterDisplay', function () {})->middleware(['verified']);
Route::get('/dashboard/onepiececharacter/edit/{card_id}','App\Http\Controllers\OnepieceController@editCharacterDisplay', function () {})->middleware(['verified']);
//posting
Route::post('/add/onepiececharacter','App\Http\Controllers\OnepieceController@addCharacter', function () {})->middleware(['verified']);
Route::post('/edit/onepiececharacter','App\Http\Controllers\OnepieceController@editCharacter', function () {})->middleware(['verified']);

// One Piece User Cards
Route::post('/add/onepieceusercard','App\Http\Controllers\OnepieceController@addUserCard', function () {})->middleware(['verified']);
Route::post('/edit/onepieceusercard','App\Http\Controllers\OnepieceController@editUserCard', function () {})->middleware(['verified']);
// hunts
Route::post('/add/onepiececardhunt','App\Http\Controllers\OnepieceController@addCardHunt', function () {})->middleware(['verified']);


// Pokemon
// Pokemon Cards
Route::get('/dashboard/pokemoncard/add','App\Http\Controllers\PokemonController@addCardDisplay', function () {})->middleware(['verified']);
Route::get('/dashboard/pokemoncard/list','App\Http\Controllers\PokemonController@listCardDisplay', function () {})->middleware(['verified']);
Route::get('/dashboard/pokemoncard/edit/{card_id}','App\Http\Controllers\PokemonController@editCardDisplay', function () {})->middleware(['verified']);
//posting
Route::post('/add/pokemoncard','App\Http\Controllers\PokemonController@addCard', function () {})->middleware(['verified']);
Route::post('/edit/pokemoncard','App\Http\Controllers\PokemonController@editCard', function () {})->middleware(['verified']);

// Pokemon User Cards
Route::post('/add/pokemonusercard','App\Http\Controllers\PokemonController@addUserCard', function () {})->middleware(['verified']);
Route::post('/edit/pokemonusercard','App\Http\Controllers\PokemonController@editUserCard', function () {})->middleware(['verified']);


// Pokemon sets
Route::get('/dashboard/pokemonset/add','App\Http\Controllers\PokemonController@addSetDisplay', function () {})->middleware(['verified']);
Route::get('/dashboard/pokemonset/list','App\Http\Controllers\PokemonController@listSetDisplay', function () {})->middleware(['verified']);
Route::get('/dashboard/pokemonset/edit/{card_id}','App\Http\Controllers\PokemonController@editSetDisplay', function () {})->middleware(['verified']);
//posting
Route::post('/add/pokemonset','App\Http\Controllers\PokemonController@addSet', function () {})->middleware(['verified']);
Route::post('/edit/pokemonset','App\Http\Controllers\PokemonController@editSet', function () {})->middleware(['verified']);
