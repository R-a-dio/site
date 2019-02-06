<?php namespace App\Http\Middleware;

use Closure;

class CacheControl {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$response = $next($request);

		if ($response->headers->get('cache-control') == null)
			$response->headers->set('cache-control', "no-transform");
		$response->headers->set("Access-Control-Allow-Origin", "*");

		return $response;
	}

}
