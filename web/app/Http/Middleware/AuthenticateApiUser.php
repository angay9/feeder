<?php namespace Feeder\Http\Middleware;

use Closure;
use Response;
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
		// No authentication header or guid header were present
		if (!$request->getUser() || !$request->header('guid')) 
		{
			return response('Unauthorized.', 401);
		}

		$credentials = [
			'email'	=>	$request->getUser(),
			'password'	=>	$request->getPassword()
		];

		if (!$this->auth->attempt($credentials) || !$this->auth->user()->devices()->count())
		{	
			$response = new ResponseError('error', ['Bad credentials']);
			return Response::json($response->toArray(), 401);
			
		}

		$guid = $request->header('guid');

		// Check if device is registered
		$devices = $this->auth->user()->devices->filter(function ($device) use ($guid) {	
			return $device->guid === $guid;
		});

		if (!$devices->count())
		{
			$response = new ResponseError('error', ['Unauthorized']);
			return Response::json($response->toArray(), 401);
		}

		return $next($request);
	}

}
