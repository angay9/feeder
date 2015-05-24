<?php namespace Feeder\Http\Controllers\Api;

use Feeder;
use Response;
use Feeder\Http\Requests;
use Illuminate\Http\Request;
use Feeder\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class InfoController extends ApiController {

	/**
	 * Show api info
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$channels = Feeder::channels();
		$info = [];
		foreach ($channels as $channel) 
		{
			$feederType = Feeder::detect($channel);
			$info[$channel] = [
				'feedTypes'	=>	$feederType::feedTypes(),
			];
		}

		return $this->setStatusCode(SymfonyResponse::HTTP_OK)->respondSuccess($info);
	}

}
