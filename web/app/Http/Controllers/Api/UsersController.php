<?php namespace Feeder\Http\Controllers\Api;

use DB;
use Request;
use Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use Feeder\Http\Requests;
use Feeder\Http\Controllers\Controller;
use Feeder\Http\Requests\CreateUserWithDeviceRequest;
use Feeder\Models\Device;
use Feeder\Models\User;

class UsersController extends ApiController {

	/**
	 * Registrar service
	 * @var RegisrarContract
	 */
	protected $registrar;

	public function __construct(RegistrarContract $registrar)
	{
		$this->middleware('auth.api', ['only' => ['services']]);

		$this->registrar = $registrar;

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateUserWithDeviceRequest $request)
	{
		$result = DB::transaction(function () {

			$user = $this->registrar->create(array_merge(Request::only('name', 'email', 'password', 'password_confirmation'), ['role' => User::ROLE_USER]));
			
			$user->devices()->save(new Device(['guid' => Request::get('guid')]));

		});
		
		return $this->setStatusCode(SymfonyResponse::HTTP_CREATED)->respondSuccess(['A new device has been succesfully registered.']);
	}

	/**
	 * Show available user services
	 * @return Response
	 */
	public function services($userId)
	{
		$user = User::find($userId);
		if ($user == null) 
		{
			return $this->setStatusCode(SymfonyResponse::HTTP_NOT_FOUND)->respondError([sprintf('No user with id %s was found', $userId)]);
		}

		$services = [];
		
		foreach ($user->services->all() as $service) 
		{
			$services[] = [
				'id'		=> 	(int) $service->id,
				'price'		=>	(float) $service->price,
				'name'		=>	$service->name,
				'feed'		=>	$service->feed,
				'is_active'	=>	(bool) $user->isServiceActive($service->id),
			];
		}

		return $this->setStatusCode(SymfonyResponse::HTTP_OK)->respondSuccess([
			'services'	=>	$services
		]);

	}

}
