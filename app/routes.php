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

	Route::get("/main", function() {
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

	Route::post("logout", function () {
		Auth::logout();
		Redirect::to("/");
	});

	

	Route::group([
			"prefix" => "admin",
			"before" => "auth",
		], function () {

		Route::get("/", "AdminController@getIndex");
		Route::get("pending-song/{id}", "DownloadController@getPendingSong");
		Route::get("song/{id}", "DownloadController@getSong");
		Route::controller("users", "UserController");
		Route::resource("profile", "ProfileController");
		Route::resource("songs", "SongController");
		Route::resource("pending", "PendingController");
		Route::resource("news", "AdminNewsController");
		Route::controller("dev", "DevController");
		
	});

	Route::resource("submit", "SubmitController");
	Route::resource("news", "NewsController");
	Route::resource("faves", "FaveController");
	Route::resource("search", "SearchController");
	Route::resource("login", "LoginController");
	Route::resource("last-played", "LastPlayedController");
	Route::resource("queue", "QueueController");
	Route::resource("irc", "IRCController");
	Route::resource("staff", "StaffController");
	Route::resource("request", "RequestController");
	Route::get("/", "HomeController@index");

	Route::controller("api", "APIController");
