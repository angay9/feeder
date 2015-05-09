<?php namespace Feeder\Http\Controllers;

use Input;
use Feeder\Http\Requests;
use Feeder\Models\Service;
use Illuminate\Http\Request;
use Feeder\Http\Controllers\Controller;
use Feeder\Http\Requests\SaveServiceRequest;

class ServicesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$services = Service::query();

		if (Input::has('filterField') && Input::has('filterValue')) 
		{
			$services->where(Input::get('filterField'), 'LIKE', '%' . Input::get('filterValue') . '%');
		}

		$services = $services->paginate(10);
		return view('services/index', compact('services'))->withInput(Input::all());
	}

	/**
	 * Display edit form
	 * @param  int $id entity id
	 * @return Response
	 */
	public function getEdit($id)
	{
		$service = Service::findOrFail($id);
		return view('services/edit', compact('service'));
	}

	/**
	 * Update service
	 * @return Response
	 */
	public function postUpdate(SaveServiceRequest $request)
	{
		$service = Service::findOrFail(Input::get('id'));
		$service->price = (double)Input::get('price');
		$service->save();
		
		return redirect()->back();
	}

}
