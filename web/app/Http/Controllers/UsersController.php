<?php namespace Feeder\Http\Controllers;

use Request;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use Feeder\Http\Requests;
use Feeder\Http\Controllers\Controller;
use Feeder\Http\Requests\CreateUserWithDeviceRequest;
use Feeder\Models\Device;
use Feeder\Models\User;

class UsersController extends Controller {

	/**
	 * Registrar service
	 * @var RegisrarContract
	 */
	protected $registrar;

	public function __construct(RegistrarContract $registrar)
	{
		$this->registrar = $registrar;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateUserWithDeviceRequest $request)
	{
		$user = $this->registrar->create(Request::only('name', 'email', 'password', 'password_confirmation'));
		$user->devices()->save(new Device(['guid' => Request::get('device_guid')]));
		return 'saved';
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
