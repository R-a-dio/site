<?php namespace App\Providers;

use Illuminate\Hashing\HashServiceProvider as ServiceProvider;
use App\Classes\RadioHasher;

class HashServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['hash'] = $this->app->share(function() { return new RadioHasher; });
	}
}
