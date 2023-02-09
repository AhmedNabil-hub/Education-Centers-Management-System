<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\UserController as ControllersUserController;

class UserController extends AdminController
{
	public function __construct()
	{
		$this->UserController = new ControllersUserController();
	}

	public function index(Request $request)
	{
		try {
			$roles = $request->filter_role ?
				(is_array($request->filter_role) ? $request->filter_role : explode(',', $request->filter_role))
				: null;

			$filters = array_filter([
				'id' => $request->filter_id ?? null,
				'username' => $request->filter_username ?? null,
				'full_name' => $request->filter_full_name ?? null,
				'status' => $request->filter_status ?? null,
				'gender' => $request->filter_gender ?? null,
				'email' => $request->filter_email ?? null,
				'phone' => $request->filter_phone ?? null,
				'address' => $request->filter_address ?? null,
				'first_time_login' => $request->filter_first_time_login ?? null,
				'role' => $roles,
			]);

			$sort = array_filter([
				'field' => User::SORT_FIELDS[$request->sort_field] ?? null,
				'order' => User::SORT_ORDERS[$request->sort_order] ?? null,
			]);

			$response = $this->UserController->index(12, $filters, $sort);

			if ($response['message'] == 'success') {
				return view('admin.content.users.index')
					->with('users', $response['data']['users']);
			}
		} catch (\Exception $e) {
			dd($e->getMessage());
			return abort(Response::HTTP_NOT_FOUND);
		}
	}

	public function create()
	{
		try {
			if (session('errors') || session('messages')) {
				return view('admin.content.users.create')
					->with('errors', session('errors', null))
					->with('messages', session('messages', null));
			}

			return view('admin.content.users.create');
		} catch (\Exception $e) {
			dd($e->getMessage());
			return abort(Response::HTTP_NOT_FOUND);
		}
	}

	public function store(StoreUserRequest $request)
	{
		try {
			$response = $this->UserController->store($request);

			if ($response['message'] == 'success') {
				return redirect()->route('admin.users.create')
					->with('messages', [
						'User created successfully',
					]);
			} else {
				return redirect()->route('admin.users.create')
					->with('errors', $response['errors']);
			}
		} catch (\Exception $e) {
			dd($e->getMessage());
			return abort(Response::HTTP_NOT_FOUND);
		}
	}

	public function show(User $user)
	{
		try {
			$response = $this->UserController->show($user);

			if (request()->ajax()) {
				if ($response['message'] == 'success') {
					return response(
						['user' => $response['data']['user']],
						Response::HTTP_ACCEPTED,
					);
				} else {
					return response(
						[
							'errors' => $response['errors'],
						],
						Response::HTTP_NOT_ACCEPTABLE
					);
				}
			} else {
				if ($response['message'] == 'success') {
					return view('admin.content.users.show')
						->with('user', $response['data']['user']);
				} else {
					return redirect()->back()
						->with('errors', $response['errors']);
				}
			}
		} catch (\Exception $e) {
			dd($e->getMessage());
			return abort(Response::HTTP_NOT_FOUND);
		}
	}

	public function showProfile()
	{
		try {
			$response = $this->UserController->show(auth()->user());

			if ($response['message'] == 'success') {
				return view('admin.content.users.profile')
					->with('user', $response['data']['user']);
			} else {
				return redirect()->back()
					->with('errors', $response['errors']);
			}
		} catch (\Exception $e) {
			dd($e->getMessage());
			return abort(Response::HTTP_NOT_FOUND);
		}
	}

	public function edit(User $user)
	{
		try {
			$response = $this->UserController->edit($user);

			if ($response['message'] == 'success') {
				if (session('errors') || session('messages')) {
					return view('admin.content.users.edit')
						->with('user', $response['data']['user'])
						->with('errors', session('errors', null))
						->with('messages', session('messages', null));
				}

				return view('admin.content.users.edit')
					->with('user', $response['data']['user']);
			} else {
				return view('info')
					->with('errors', $response['errors']);
			}
		} catch (\Exception $e) {
			dd($e->getMessage());
			return abort(Response::HTTP_NOT_FOUND);
		}
	}

	public function update(UpdateUserRequest $request, User $user)
	{
		try {
			$response = $this->UserController->update($request, $user);

			if ($response['message'] == 'success') {
				return redirect()->route('admin.users.edit', $user->id)
					->with('messages', [
						'User updated successfully',
					]);
			} else {
				return redirect()->route('admin.users.edit', $user->id)
					->with('errors', $response['errors']);
			}
		} catch (\Exception $e) {
			dd($e->getMessage());
			return abort(Response::HTTP_NOT_FOUND);
		}
	}

	public function destroy(User $user)
	{
		try {
			$response = $this->UserController->destroy($user);

			if (request()->ajax()) {
				if ($response['message'] == 'success') {
					return response(
						[
							'messages' => ['User deleted successfully'],
						],
						Response::HTTP_ACCEPTED
					);
				} else {
					return response(
						[
							'errors' => $response['errors'],
						],
						Response::HTTP_NOT_ACCEPTABLE
					);
				}
			} else {
				if ($response['message'] == 'success') {
					return redirect()->route('admin.users.index')
						->with('messages', [
							'User deleted successfully',
						]);
				} else {
					return redirect()->back()
						->with('errors', $response['errors']);
				}
			}
		} catch (\Exception $e) {
			dd($e->getMessage());
			return abort(Response::HTTP_NOT_FOUND);
		}
	}
}
