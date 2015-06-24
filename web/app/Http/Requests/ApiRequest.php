<?php namespace Feeder\Http\Requests;

use Response;
use Illuminate\Foundation\Http\FormRequest;
use Feeder\Api\Responses\ResponseError; 

abstract class ApiRequest extends FormRequest {

	/**
	 * Respond with validation errors
	 * @override
	 * @param  array  $errors validation errors
	 * @return Response
	 */
	public function response(array $errors)
	{
		$response = new ResponseError('error', $errors);
		
		return Response::json($response->toArray(), 422);
	}

	/**
	 * Respond with authorization error
	 * @override 
	 * @return Response
	 */
	public function forbiddenResponse()
    {
    	$response = new ResponseError('error', ['Permission denied']);
    	return Response::json($response->toArray(), 403);
    }

}
