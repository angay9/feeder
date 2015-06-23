<?php namespace Feeder\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model {

	protected $table = 'user_logs';
	protected $fillable = ['user_id', 'log', 'info'];

	const USER_REGISTERED = 1;
	const USER_ORDERED_SERVICE = 2;
	const SERVICE_ACCESS_GRANTED = 3;

	const HUMAN_LOG_NAMES = [
		self::USER_REGISTERED => 'User registered a new account',
		self::USER_ORDERED_SERVICE => 'User ordered a new service',
		self::SERVICE_ACCESS_GRANTED => 'Access was granted to a new service',
	];

	public function user()
	{
		return $this->belongsTo('\Feeder\Models\User');
	}

	public static function log($user, $eventType, $info = '')
	{
		$events = [
			static::USER_REGISTERED,
			static::USER_ORDERED_SERVICE,
			static::SERVICE_ACCESS_GRANTED,
		];

		if (!in_array($eventType, $events))
			throw new \InvalidArgumentException("Event $event is not recognized");

		static::create([
			'log'	=>	$eventType,
			'user_id'	=>	$user->id,
			'info'	=>	$info
		]);
	}

	public static function logUserRegistered($user)
	{
		self::log($user,
			static::USER_REGISTERED,
			'User: ' . $user->name . ' [' . $user->email . '].'
		);
	}

	public static function logUserOrderedService($user, $service)
	{
		self::log(
			$user,
			static::USER_ORDERED_SERVICE,
			'User: ' . $user->name . ' [' . $user->email . ']. Service: ' . $service->name . ' | ' . $service->feed
		);
	}

	public static function logServiceAccessGranted($user, $service, $pivot)
	{
		self::log(
			$user,
			static::SERVICE_ACCESS_GRANTED,
			'Access to a service ' . $service->name . ' | ' . $service->feed . ' changed to: ' . ($pivot->is_active ? 'active' : 'not active')
		);
	}

	public function getHumanLogName()
	{
		return static::HUMAN_LOG_NAMES[$this->log];
	}
}
