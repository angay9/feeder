<?php namespace Feeder\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Feeder\Models\UserService;

class ChangeServicesStatus extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'services:check';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Activate/Deactivate service status based on it\'s expiration date.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$services = UserService::all();
		foreach($services as $service) 
		{
			if (\DateTime::createFromFormat('Y-m-d H:i:s', $service->active_until) < new \DateTime('now')) 
			{
				$service->is_active = false;
				$service->save();
			}
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
		];
	}

}
