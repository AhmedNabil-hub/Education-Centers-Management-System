<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FormRequestPreventAutoValidation;

class UpdateUserRequest extends FormRequest
{
	use FormRequestPreventAutoValidation;

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		$is_required = 'required';
		$is_phone_required = 'required';
		$is_email_required = 'required';
		$is_ajax_required = 'required';

		if (
			in_array(getPrevRouteName(), ['admin.users.profile', 'users.profile']) ||
			$this->ajax()
		) {
			$is_required = 'nullable';
		}

		if(
			$this->ajax()
		) {
			$is_phone_required = 'nullable';
		}

		if(
			$this->ajax()
		) {
			$is_email_required = 'nullable';
		}

		if(
			$this->ajax()
		) {
			$is_ajax_required = 'nullable';
		}

		return [
			'username' => $is_ajax_required . '|string|min:3|unique:users,username,' . $this->route('user')->id . ',id',
			'full_name' => $is_ajax_required . '|string|min:3',
			'status' => $is_required . '|in:' . implode(',', array_keys(User::STATUS)),
			'gender' => $is_ajax_required . '|in:' . implode(',', array_keys(User::GENDER)),
			'email' => $is_email_required . '|email|unique:users,email,' . $this->route('user')->id . ',id',
			'phone' => $is_phone_required . '|string|regex:/^01[0125][0-9]{8}$/|unique:users,phone,' . $this->route('user')->id . ',id',
			'password' => 'nullable|min:6',
			'address' => $is_ajax_required . '|string',
			'roles' => 'nullable|array',
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
