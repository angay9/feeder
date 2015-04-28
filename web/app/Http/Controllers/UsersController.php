<?php namespace Feeder\Http\Controllers;

use Input;
use Illuminate\Http\Request;
use Feeder\Http\Requests;
use Feeder\Http\Controllers\Controller;
use Feeder\Models\User;

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

}
