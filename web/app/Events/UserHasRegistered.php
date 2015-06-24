<?php namespace Feeder\Events;

use Feeder\Events\Event;

use Illuminate\Queue\SerializesModels;

class UserHasRegistered extends Event {

	use SerializesModels;

	public $userId;

	public $serviceId;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($user)
	{
		$this->user = $user;
	}

}
