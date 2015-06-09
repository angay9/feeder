<?php 

namespace Feeder\Console\Commands;

use DB;
use Feeder;
use Feeder\Models\Feed;
use Feeder\Models\Service;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class FetchFeeds extends Command  {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'feeds:fetch';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Fetches feeds into a database.';

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
		Feeder::store();
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
