<?php namespace Feeder\Services;

abstract class AbstractFeeder implements FeederInterface {
	
	protected $url;

	protected $feedType;

	protected $feeds;

	abstract public function fetch();

	abstract public static function feedTypes();	
	
}