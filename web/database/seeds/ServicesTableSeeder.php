<?php

use Feeder\Models\Service;
use Feeder\Services\BBCFeeder;
use Feeder\Services\ESPNFeeder;
use Feeder\Services\NYTFeeder;
use Feeder\Services\YahooFeeder;
use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder {

    public function run()
    {
    	// BBC
    	foreach (BBCFeeder::feedTypes() as $type) 
    	{
    		Service::create([
	        	'name'	=>	'bbc',
	        	'feed'	=>	$type,
	        	'price'	=>	rand(20, 50) * rand(1, 3)
        	]);
    	}
        
    	// ESPN
    	foreach (ESPNFeeder::feedTypes() as $type) 
    	{
    		Service::create([
	        	'name'	=>	'espn',
	        	'feed'	=>	$type,
	        	'price'	=>	rand(20, 50) * rand(1, 3)
        	]);
    	}

    	// New York Times
    	foreach (NYTFeeder::feedTypes() as $type) 
    	{
    		Service::create([
	        	'name'	=>	'nyt',
	        	'feed'	=>	$type,
	        	'price'	=>	rand(20, 50) * rand(1, 3)
        	]);
    	}

    	// Yahoo
    	foreach (YahooFeeder::feedTypes() as $type) 
    	{
    		Service::create([
	        	'name'	=>	'yahoo',
	        	'feed'	=>	$type,
	        	'price'	=>	rand(20, 50) * rand(1, 3)
        	]);
    	}

    }

}