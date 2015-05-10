<?php namespace Feeder\Http\Controllers;

use Input;
use Feeder\Models\User;
use Illuminate\Http\Request;
use Feeder\Models\Service;
use Feeder\Models\UserService;
use Feeder\Http\Controllers\Controller;
use Feeder\Http\Requests\SaveUserRequest;

class UsersController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$users = User::where('role', '!=', User::ROLE_ADMIN)
					->with('devices');
		if (Input::has('filterField') && Input::has('filterValue')) 
		{
			$users->where(Input::get('filterField'), 'LIKE', '%' . Input::get('filterValue') . '%');
		}

		$users = $users->paginate(20);
		return view('users/index', compact('users'))->withInput(Input::all());
	}

	/**
	 * Show a user profile
	 * 
	 * @return Response
	 */
	public function getShow($id)
	{
		$user = User::with('services')->with('devices')->findOrFail($id);
		
		$services = Service::all();

		return view('users/show', compact('user', 'services'));
	}

	/**
	 * Save user
	 * 
	 * @return Response
	 */
	public function postSave(SaveUserRequest $request)
	{
		$id = Input::get('id'); // user id
		$userServices = UserService::where('user_id', '=', $id)->get(); // get all user services
		$services = Input::get('services') ?: []; // get services that have to be set to active
		
		$userServices->each(function ($pivot) use ($services) 
		{
			if (in_array($pivot->service_id, $services))
			{
				$pivot->is_active = true;
			}
			else 
			{
				$pivot->is_active = false;
			}
			$pivot->save();
		});

		// UserService::where('user_id', '=', $id)->whereIn('service_id', $services)->update(['is_active' => true]);

		return redirect()->back();
	}

}
