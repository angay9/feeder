<?php namespace Feeder\Events;

use Feeder\Events\Event;

use Illuminate\Queue\SerializesModels;

class ServiceWasPurchased extends Event {

	use SerializesModels;

	public $userId;

	public $serviceId;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($userId, $serviceId)
	{
		$this->userId 		=	$userId;
		$this->serviceId 	=	$serviceId;
	}

}
