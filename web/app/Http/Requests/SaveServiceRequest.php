<?php namespace Feeder\Http\Requests;

use Feeder\Http\Requests\Request;
use Auth;

class SaveServiceRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return Auth::user()->isAdmin();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'price'	=>	'required|numeric'
		];
	}

}
