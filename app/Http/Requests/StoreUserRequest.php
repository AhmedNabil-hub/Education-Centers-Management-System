<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FormRequestPreventAutoValidation;

class StoreUserRequest extends FormRequest
{
	use FormRequestPreventAutoValidation;

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'username' => 'required|string|unique:users,username|min:3',
			'full_name' => 'required|string|min:3',
			'status' => 'required|in:0,1',
			'gender' => 'required|in:0,1',
			'email' => 'required|email|unique:users,email',
			'phone' => 'required|string|unique:users,phone|regex:/^01[0125][0-9]{8}$/',
			'password' => 'required|min:6',
			'address' => 'required|string',
			'roles' => 'required|array',
			'roles.*' => 'required|in:' . implode(',', array_keys(User::ROLES)),
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
