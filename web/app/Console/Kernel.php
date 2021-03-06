<?php namespace Feeder\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'Feeder\Console\Commands\Inspire',
		'Feeder\Console\Commands\FetchFeeds',
		'Feeder\Console\Commands\ChangeServicesStatus',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('feeds:fetch')
				 ->twiceDaily();
		$schedule->command('services:check')
				  ->daily();
	}

}
