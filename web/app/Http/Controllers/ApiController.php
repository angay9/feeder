<?php

namespace Feeder\Http\Controllers;
use \Response;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Feeder\Http\Controllers\Controller;
use Feeder\Api\Responses\ResponseSuccess;
use Feeder\Api\Responses\ResponseError;


class ApiController extends BaseController {


	use DispatchesCommands, ValidatesRequests;

	/**
	 * Status code of a response
	 * @var int
	 */
	protected $statusCode;

	/**
	 * Response dto object
	 * @var Feeder\Api\Responses\
	 */
	protected $response;

	/**
	 * Set a status code
	 * @param int $statusCode
	 */
	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;

		return $this;
	}

	/**
	 * Respond with error
	 * @param  array  $messages
	 * @return Response
	 */
	public function respondError(array $messages)
	{
		$response = new ResponseError('error', $messages);

		return Response::json($response->toArray());
	}

	/**
	 * Response with a success message
	 * @param  mixed $data
	 * @return Response
	 */
	public function respondSuccess($data)
	{
		$response = new ResponseSuccess('success', $data);
		
		return Response::json($response->toArray());
	}

}