<?php namespace Feeder\Http\Requests;

use Feeder\Http\Requests\Request;

class CreatePaymentRequest extends ApiRequest {

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
			'serviceId'		=>	'required|numeric|exists:services,id',
		];
	}

}
