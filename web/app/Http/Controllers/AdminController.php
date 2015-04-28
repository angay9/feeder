<?php namespace Feeder\Http\Controllers;

use Feeder\Http\Requests;
use Feeder\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminController extends Controller {

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
		return view('admin/index');
	}

}
