<?php namespace Feeder\Services;

interface FeederInterface {

	public function fetch();

	public function validate($feedType);
}
