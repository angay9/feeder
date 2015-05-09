<?php namespace Feeder\Http\Controllers\Api;

use DB;
use Input;
use Feeder\Http\Requests;
use Feeder\Models\Payment;
use Illuminate\Http\Request;
use Feeder\Models\UserService;
use Feeder\Events\ServiceWasPurchased;
use Feeder\Http\Controllers\Controller;
use Feeder\Http\Requests\CreatePaymentRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class PaymentsController extends ApiController {

	/**
	 * Create a new resource.
	 *
	 * @return Response
	 */
	public function store(CreatePaymentRequest $request)
	{
		try {
			
			DB::transaction(function () {
				$userId 	=	Input::get('userId');
				$serviceId 	=	Input::get('serviceId');
				
				Payment::create([
					'user_id'		=>	$userId,
					'service_id'	=>	$serviceId,
					'created_at'	=>	new \DateTime,
				]);
				
				UserService::create([
					'user_id'		=>	$userId,
					'service_id'	=>	$serviceId,
					'is_active'		=>	false,
					'active_until'	=>	(new \DateTime)->modify('+1 month'),
				]);

			});

			event('service.was_purchased', new ServiceWasPurchased(Input::get('userId'), Input::get('serviceId')));
			
			return $this->setStatusCode(SymfonyResponse::HTTP_CREATED)->respondSuccess('Operation was succesful.');			
		} catch (\Exception $e) {
			return $this->setStatusCode(SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR)->respondError([$e->getMessage()]);
		}
		
				
	}

}
