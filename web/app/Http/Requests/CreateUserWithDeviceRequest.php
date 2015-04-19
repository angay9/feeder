<?php namespace Feeder\Http\Requests;

use Response;

class CreateUserWithDeviceRequest extends ApiRequest {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name'	=>	'required|min:4',
			'email'	=>	'required|email|unique:users',
			'password'	=>	'required|min:6|confirmed',
			'guid' => 'required|min:10|unique:devices'
			// 'password_confirmation'	=>	'required'
		];
	}

}
