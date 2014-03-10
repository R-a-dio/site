<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',
	app_path().'/traits',

));

/*
|--------------------------------------------------------------------------
| Sentry Error Handler
|--------------------------------------------------------------------------
|
| Distributed error logging using the $_ENV["SENTRY_KEY"] URL to send
| events to. Setting app.sentry to false will result in sentry errors
| being skipped over. This will not log errors to disk.
|
*/
function sentry_log($exception, $code = 500) {
	$sentry = Config::get("app.sentry", false);
	if ($sentry) {
		$client = new Raven_Client($sentry, [
			"tags" => [
				"http_code" => $code,
			],
		]);

		if ($code < 500 and $code >= 400) {
			$id = $client->getIdent($client->captureMessage($exception));
		} else {
			$id = $client->getIdent($client->captureException($exception));
		}

		return [
			"error" => $exception->getMessage(),
			"trace" => $exception->getTraceAsString(),
			"line" => $exception->getLine(),
			"file" => $exception->getFile(),
		];
	}

	return null;
}

/*
|--------------------------------------------------------------------------
| R/a/dio Error View
|--------------------------------------------------------------------------
|
| Dumps out a generic localised error page using a code.
|
*/
function radio_error($exception, $code = 500) {
	View::share("theme", "default");
	View::share("error", $code);
	View::share("reference", sentry_log($exception, $code));
	$view = Request::ajax() ? View::make("ajax") : View::make("master");
	$view->content = View::make("layouts.error");

	return $view;
}

/*
|--------------------------------------------------------------------------
| Primary Error Handlers
|--------------------------------------------------------------------------
|
| This will grab regular and fatal errors and pass them to sentry,
| showing a 500 error view if app.debug is false.
|
*/
App::error(function(Exception $exception, $code)
{
	return radio_error($exception, 500);
});

App::fatal(function($exception)
{
	return radio_error($exception, 500);
});

/*
|--------------------------------------------------------------------------
| ModelNotFoundException handler
|--------------------------------------------------------------------------
| Thrown when a model isn't found. By default this would usually be the
| output from User::findOrFail() or Set::findOrFail().
| Logs a 404 and then shows a 404 view.
|
*/
App::error(function(ModelNotFoundException $exception, $code)
{
	return radio_error("Model not found at /" . Request::path(), 404);
});

/*
|--------------------------------------------------------------------------
| 404 Logger
|--------------------------------------------------------------------------
| Logs 404 errors with the sentry tag "404" and returns a 404 view
|
*/
App::missing(function($exception)
{
	return radio_error("404 at /" . Request::path(), 404);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenace mode is in effect for this application.
|
*/

App::down(function()
{
	// bypass maintenance mode for devs who logged in earlier
	if (Auth::check() and Auth::user()->isDev())
		return null;

	View::share("theme", "default");
	View::share("error", 503);
	$view = Request::ajax() ? View::make("ajax") : View::make("master");
	$view->content = View::make("layouts.error");

	return $view;
});

// timeago function for all dates
function time_ago($date) {
	$date = is_numeric($date) ? (int) $date : strtotime($date);

	// jquery.timeago.js requires an ISO8601 timestamp in the title
	$timeago = date(DATE_ISO8601, $date);

	// This part is optional, but why not
	$time = date("H:i:s", $date);

	// Using the <time> HTML5 element instead of <abbr>
	return "<time class=\"timeago\" datetime=\"$timeago\">$time</time>";
}



/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';
