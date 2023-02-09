<?php

namespace App\Http\Requests;

use App\Traits\FormRequestPreventAutoValidation;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
	use FormRequestPreventAutoValidation;

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'username' => 'required|min:3|string|unique:users,username',
			'email' => 'required|email|unique:users,email',
			'password' => 'required|min:6',
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
