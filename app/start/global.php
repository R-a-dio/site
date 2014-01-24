<?php

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
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a rotating log file setup which creates a new file each day.
|
*/

$logFile = 'laravel.log';

Log::useDailyFiles(storage_path().'/logs/'.$logFile);

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	$sentry = Config::get("app.sentry", false);

	if ($sentry) {
		// grab monolog to add a handler to it
		$monolog = Log::getMonolog();

		// Create a sentry/raven client
		$client = new Raven_Client($sentry);

		// handler time
		$handler = new Monolog\Handler\RavenHandler($client,
			Monolog\Logger::ERROR);

		// cleanup on formatting
		//$handler->setFormatter(new Monolog\Formatter\LineFormatter("%message% %context% %extra%\n"));

		// add sentry to monolog
		$monolog->pushHandler($handler);
	}

	// display the error with whatever error handler is installed (whoops)
	Log::error($exception);
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
	return Response::make("Be right back!", 503);
});

// timeago function for all dates
function time_ago($date) {
	$date = is_numeric($date) ? (int) $date : strtotime($date);

	// jquery.timeago.js requires an ISO8601 timestamp in the title
	$timeago = date(DATE_ISO8601, $date);

	// This part is optional, but why not
	$time = date(DATE_RFC850, $date);

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
