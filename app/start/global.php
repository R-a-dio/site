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
	app_path().'/controllers/admin',
	app_path().'/controllers/site',
	app_path().'/controllers/api',
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
			// $id = $client->getIdent($client->captureMessage($exception));
		} else {
			$id = $client->getIdent($client->captureException($exception));

			return [
				"error" => get_class($exception) . ": " . $exception->getMessage(),
				"trace" => $exception->getTraceAsString(),
				"line" => $exception->getLine(),
				"file" => $exception->getFile(),
			];
		}
	}
	
	if(!is_object($exception))
		return null;
	
	return [
		"error" => get_class($exception) . ": " . $exception->getMessage(),
		"trace" => $exception->getTraceAsString(),
		"line" => $exception->getLine(),
		"file" => $exception->getFile(),
	];
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
	if (App::runningInConsole()) {
		return [
			"error" => get_class($exception) . ": " . $exception->getMessage(),
			"trace" => $exception->getTraceAsString(),
			"line" => $exception->getLine(),
			"file" => $exception->getFile(),
		];
	}

	View::share("theme", "default");
	View::share("error", $code);
	View::share("reference", sentry_log($exception, $code));
	$view = Request::ajax() ? View::make("ajax") : View::make("master");
	$view->content = View::make("layouts.error");

	return $view;
}

function requestable($lastplayed, $requests) {
	$delay = delay($requests);

	return (time() - $lastplayed) > $delay;
}

function delay($priority) {
	// priority is 30 max
		if ($priority > 30)
			$priority = 30;

		// between 0 and 7 return magic
		if ($priority >= 0 and $priority <= 7)
			return -11057 * $priority * $priority + 172954 * $priority + 81720;
		// if above that, return magic crazy numbers
		else
			return (int) (599955 * exp(0.0372 * $priority) + 0.5);
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
	if (App::runningInConsole() or Request::ajax()) {
		return [
			"error" => 404
		];
	}

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
	// we need a way to check if the site is pingable from the maintenance site
	if (Request::is("api/ping"))
		return Response::json(["ping" => false]);

	// bypass maintenance mode for devs who logged in earlier
	if (Auth::check() and Auth::user()->isDev())
		return null;

	return Redirect::to("https://static.r-a-d.io/maintenance/");
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

function can_request($ip) {
	$user = DB::table("requesttime")
		->where("ip", "=", $ip)
		->first();

	if (!$user)
		return true;

	$time = time() - strtotime($user["time"]);

	// you can request every 2 hours.
	return $time > (3600 * 2);
}

function base64url_encode($data) {
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data) {
  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

// daypass~
function daypass() {
	// default daypass is "testingYYYY-MM-DD" sha256'd and truncated.
	$raw = Config::get("radio.daypass", "testing") . date("Y-m-d");

	$hash = base64_encode(hash("sha256", $raw));

	return substr($hash, 0, 16);
}

function daypass_crypt($data) {
	// get the raw sha256 hexadecimal and convert it to base 10
	$seed = hexdec(substr(base64_decode(daypass()), 0, 8));

	// seed mt random with this int
	mt_srand($seed);

	// loop through each digit of the string to be encrypted
	for ($i = 0; $i < strlen($data); $i++) {
		// XOR each digit using a random int, then convert to ascii.
		// as the rng is seeded, doing this a second time will flip the digits back.
		// also means the links change daily, which is handy.
		$data[$i] = chr(ord($data[$i]) ^ (mt_rand() & 127));
	}

	return $data;
}

// Encode a string for raw slack formatting
function slack_encode($text) {
	// these are the only characters that are not permitted in slack.
	return str_replace(["&", "<", ">"], ["&amp;", "&lt;", "&gt;"], $text);
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
