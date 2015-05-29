<?php namespace Feeder\Console\Commands;

use DB;
use Feeder;
use Feeder\Models\Feed;
use Feeder\Models\Service;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class FetchFeeds extends Command {

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
		$channels = Feeder::channels();

		foreach ($channels as $ch) 
		{
			$feederClass = Feeder::detect($ch);
			$feedTypes = $feederClass::feedTypes();

			foreach($feedTypes as $type) 
			{
				$feeder = Feeder::make($ch, $type);
				foreach($feeder->fetch() as $f) 
				{
					DB::transaction(function () use ($ch, $type, $f) {
						$service = Service::where('name', '=', $ch)->where('feed', '=', $type)->first();
						if ($service === null) 
						{
							dd('no_service');
						}
						if ($f == null) {
							dd($f, $ch, $type);
						}

						$entity = new Feed;
						$entity->title 			=	$f->title;
						$entity->link 			=	$f->link;
						$entity->description 	=	$f->description;
						$entity->pub_date 		=	$f->pubDate;
						$entity->service_id 	=	$service->id;
						$entity->save();

					});
				}
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
