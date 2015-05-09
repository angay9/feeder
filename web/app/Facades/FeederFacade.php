<?php namespace Feeder\Facades;

use Illuminate\Support\Facades\Facade;

class FeederFacade extends Facade {

    protected static function getFacadeAccessor() { return 'feeder'; }

}
