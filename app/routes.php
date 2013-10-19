<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
$base = Config::get("app.base", "");
# Index.
Route::get($base . '/', 'Home@showHome');

# News - aggregate + single
Route::get($base . '/news', 'News@showNews');
Route::get($base . '/news/{id}', 'News@showSingleNews')
	->where('id', '[0-9]+');

# Stats
Route::get($base . '/stats', 'Stats@showGraphs');
Route::get($base . '/stats.json', 'Stats@getGraphsAjax');

# IRC
Route::get($base . '/irc', 'IRC@show');

# Search
Route::any($base . '/search/{search?}', 'Search@showResults');


# Admin controller; adds extra auth + security
Route::controller($base . '/admin', 'Admin');
