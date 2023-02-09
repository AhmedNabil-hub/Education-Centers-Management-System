<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FormRequestPreventAutoValidation;

class UserLoginRequest extends FormRequest
{
	use FormRequestPreventAutoValidation;

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'email' => 'required|email',
			'password' => 'required',
			'remember' => 'nullable',
		];
	}

	public function messages()
	{
		return [
			'required' 	=> ':attribute is required',
			'string' 		=> ':attribute must be a string',
			'integer' 	=> ':attribute must be an integer',
			'unique' 		=> 'This :attribute already exists',
			'exists' 		=> 'This :attribute does not exists',
			'between' 	=> 'This :attribute must be between :min and :max',
			'min'				=> 'This :attribute must be more than :min',
			'regex'			=> 'This :attribute is not correct',
		];
	}

	public function attributes()
	{
		return [];
	}
}
