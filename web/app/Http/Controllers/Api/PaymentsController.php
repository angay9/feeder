<?php namespace Feeder\Http\Controllers\Api;

use Input;
use Feeder\Http\Requests;
use Feeder\Models\Payment;
use Illuminate\Http\Request;
use Feeder\Events\ServiceWasPurchased;
use Feeder\Http\Controllers\Controller;
use Feeder\Http\Requests\CreatePaymentRequest;
use DB;

class PaymentsController extends Controller {

	/**
	 * Create a new resource.
	 *
	 * @return Response
	 */
	public function store(CreatePaymentRequest $request)
	{

		event('service.was_purchased', new ServiceWasPurchased(Input::get('userId'), Input::get('serviceId')));
		
		// DB::transaction(function () {
		// 	Payment::create([
		// 		'user_id'		=>	Input::get('userId'),
		// 		'service_id'	=>	Input::get('serviceId'),
		// 	]);

		// 	// Create users_services model
		// });		
		
	}

}
