<?php namespace Feeder\Http\Requests;

use Feeder\Http\Requests\Request;
use Auth;

class SaveUserRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return Auth::user() && Auth::user()->isAdmin();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'id'	=>	'required|numeric|exists:users',
		];
	}

}
