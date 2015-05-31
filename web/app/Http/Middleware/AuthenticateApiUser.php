<?php namespace Feeder\Http\Middleware;

use Route;
use Closure;
use Response;
use Feeder\Models\Service;
use Illuminate\Contracts\Auth\Guard;
use Feeder\Api\Responses\ResponseError;

class AuthenticateApiUser {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!$this->validateCredentials($request)) 
		{
			$response = new ResponseError('error', ['Unauthorized']);
			return Response::json($response->toArray(), 401);
		}

		return $next($request);
	}

	/**
	 * Validate user credentials
	 * @param  \Illuminate\Http\Request $request
	 * @return bool
	 */
	private function validateCredentials($request) 
	{
		
		
		// No authentication header or guid header were present
		if (!$request->getUser() || !$request->header('guid')) 
		{
			return false;
		}

		$credentials = [
			'email'	=>	$request->getUser(),
			'password'	=>	$request->getPassword()
		];
		

		if (!$this->auth->attempt($credentials) || !$this->auth->user()->devices()->count()) return false;

		$guid = $request->header('guid');
		

		// Check if device is registered
		$devices = $this->auth->user()->devices->filter(function ($device) use ($guid) {	
			return $device->guid === $guid;
		});

		if (!$devices->count()) return false;

		return true;
	}


}
