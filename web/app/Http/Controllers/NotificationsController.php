<?php namespace Feeder\Http\Controllers;

use Input;
use Feeder\Http\Requests;
use Feeder\Models\UserLog;
use Illuminate\Http\Request;
use Feeder\Http\Controllers\Controller;
use Feeder\Http\Requests\SaveServiceRequest;

class NotificationsController extends Controller {

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
		$notifications = UserLog::orderBy('updated_at', 'DESC');

		if (Input::has('filterField') && Input::has('filterValue')) 
		{
			$notifications->where(Input::get('filterField'), 'LIKE', '%' . Input::get('filterValue') . '%');
		}

		if (Input::has('orderField') && Input::has('orderDir')) 
		{
			$notifications->orderBy(Input::get('orderField'), Input::get('orderDir'));
		}

		$notifications = $notifications->paginate(10);
		return view('notifications/index', compact('notifications'))->withInput(Input::all());
	}

}
