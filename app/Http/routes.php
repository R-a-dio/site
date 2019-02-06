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

# stream links
Route::get("/main.mp3", function() {
	return Redirect::to("//stream.r-a-d.io/main");
});

Route::get("/stream", function() {
	return Redirect::to("//stream.r-a-d.io/main");
});

Route::get("/stream.mp3", function() {
	return Redirect::to("//stream.r-a-d.io/main");
});

Route::get("/R-a-dio", function() {
	return Redirect::to("//stream.r-a-d.io/main");
});

# API controller
Route::controller("/api", "API");

# Admin controller; adds extra auth + security
Route::controller('/admin', 'Admin');

# Index.
Route::controller('/', 'Home');
