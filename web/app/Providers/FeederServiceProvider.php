<?php namespace Feeder\Providers;

use Illuminate\Support\ServiceProvider;
use Feeder\Services\Feeder;

class FeederServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('feeder', function () {
			return new Feeder;
		});
	}

}
