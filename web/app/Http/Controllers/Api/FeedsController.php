<?php namespace Feeder\Http\Controllers\Api;

use Feeder;
use Response;
use Exception;
use Illuminate\Http\Request;
use Feeder\Services\YahooFeeder;
use Feeder\Exceptions\FeederException;
use Feeder\Api\Responses\ResponseError;
use Feeder\Http\Controllers\Api\ApiController;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class FeedsController extends ApiController {

	public function __construct()
	{
		$this->middleware('auth.api');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($channel, $feedType)
	{
		try {
			
			$feeder = Feeder::make($channel, $feedType);
			
			return $feeder->fetch();

		} catch (FeederException $e) {
			
			return $this->setStatusCode(SymfonyResponse::HTTP_NOT_FOUND)->respondError([$e->getMessage()]);	
		}
				
	}

}
