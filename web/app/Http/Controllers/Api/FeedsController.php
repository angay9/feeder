<?php namespace Feeder\Http\Controllers\Api;

use Feeder;
use Response;
use Exception;
use Feeder\Models\Service;
use Illuminate\Http\Request;
use Feeder\Services\YahooFeeder;
use Feeder\Exceptions\FeederException;
use Feeder\Api\Responses\ResponseError;
use Feeder\Http\Controllers\Api\ApiController;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class FeedsController extends ApiController {

	public function __construct()
	{
		// $this->middleware('auth.api');
		// $this->middleware('auth.api.channel_access');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($channel, $feedType, $offset = 0, $limit = 10)
	{
		try {
			$service = Service::where('name', '=', $channel)->where('feed', '=', $feedType)->first();
			
			if ($service === null) {
				return $this->respondError(["Unknown $service. $channel or $feedType does not exist"]);
			}
			
			return $service->feeds()->offset($offset)->take($limit)->get();

		} catch (FeederException $e) {
			
			return $this->setStatusCode(SymfonyResponse::HTTP_NOT_FOUND)->respondError([$e->getMessage()]);	
		}
				
	}

}
