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

Route::get('/', 'Home@showHome');

Route::get('/news', 'News@showNews');
Route::get('/news/{id}', 'News@showSingleNews')
	->where('id', '[0-9]+');

Route::get('/stats', 'Stats@showGraphs');
Route::get('/stats.json', 'Stats@getGraphsAjax');

Route::controller('/admin', 'Admin');



