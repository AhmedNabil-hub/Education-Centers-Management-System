<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FormRequestPreventAutoValidation;

class UserRegisterSecondRequest extends FormRequest
{
	use FormRequestPreventAutoValidation;

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'full_name' => 'required|min:3|string',
			'gender' => 'required|in:' . implode(',', array_keys(User::GENDER)),
			'phone' => 'required|string|unique:users,phone|regex:/^01[0125][0-9]{8}$/',
			'address' => 'nullable|string',
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
		return [
			'full_name' => 'full name',
		];
	}
}
