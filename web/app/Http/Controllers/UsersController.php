<?php namespace Feeder\Http\Controllers;

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
		$this->middleware('auth.api', ['only' => ['update']]);

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

			$user = $this->registrar->create(Request::only('name', 'email', 'password', 'password_confirmation'));
			
			$user->devices()->save(new Device(['guid' => Request::get('guid')]));

		});
		
		return $this->setStatusCode(SymfonyResponse::HTTP_OK)->respondSuccess(['A new device has been succesfully registered.']);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

}
