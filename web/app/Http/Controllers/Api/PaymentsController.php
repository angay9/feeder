<?php namespace Feeder\Http\Controllers\Api;

use DB;
use Auth;
use Input;
use Feeder\Http\Requests;
use Feeder\Models\Payment;
use Illuminate\Http\Request;
use Feeder\Models\UserService;
use Feeder\Events\ServiceWasPurchased;
use Feeder\Http\Controllers\Controller;
use Feeder\Http\Requests\CreatePaymentRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Feeder\Models\UserLog;

class PaymentsController extends ApiController {

	public function __construct()
	{
		$this->middleware('auth.api');
	}

	/**
	 * Create a new resource.
	 *
	 * @return Response
	 */
	public function store(CreatePaymentRequest $request)
	{
		try {
			
			$userId = Auth::user()->id;

			$serviceId = Input::get('service_id');
			
			$record = UserService::where('user_id', '=', $userId)->where('service_id', '=', $serviceId)->first();

			if ($record !== null && $record->is_active) 
			{
				return $this->setStatusCode(SymfonyResponse::HTTP_CONFLICT)->respondError(['You have already purchased this service.']);
			}

			DB::transaction(function () use ($userId, $serviceId) {
				
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
			UserLog::logUserOrderedService(Auth::user());
			event('service.was_purchased', new ServiceWasPurchased($userId, $serviceId));
			
			return $this->setStatusCode(SymfonyResponse::HTTP_CREATED)->respondSuccess('Operation was succesful.');
		} catch (\Exception $e) {
			return $this->setStatusCode(SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR)->respondError([$e->getMessage()]);
		}
	}

}
