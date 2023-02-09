<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Main\MediafileController;

class UserController extends Controller
{
	public function index($pagination = null, $filters = null, $sort = null)
	{
		try {
			$users = User::query()
				->with([
					'mediafile',
				])
				->when($filters != null, function ($query) use ($filters) {
					$query->filterUser($filters);
				})
				->when($sort != null, function ($query) use ($sort) {
					$query->sortUser($sort);
				});

			if ($pagination != null) {
				$inputs = request()->input();
				$users = $users->paginate($pagination)->withQueryString();
			} else {
				$users = $users->get();
			}

			$users = getResourceResponse(
				request(),
				'user',
				'Collection',
				$users
			);

			request()->flash();

			return [
				'message' => 'success',
				'data' => [
					'users' => $users,
				],
			];
		} catch (\Exception $e) {
			return [
				'message' => 'fail',
				'errors' => [
					$e->getMessage(),
				],
			];
		}
	}

	public function create()
	{
		//
	}

	public function store(StoreUserRequest $request)
	{
		try {
			$validator = Validator::make(
				$request->all(),
				$request->rules(),
				$request->messages(),
				$request->attributes()
			);

			if ($validator->fails()) {
				$request->flash();

				return [
					'message' => 'fail',
					'errors' => $validator->getMessageBag()->all(),
				];
			}

			$validated_data = $validator->validated();

      $validated_data['email_verified_at'] = now();
			$validated_data['first_time_login'] = 0;
			$validated_data['password'] = Hash::make($validated_data['password']);

			$user = User::create($validated_data);

			if($validated_data['roles'] != null) {
				foreach ($validated_data['roles'] as $key => $role) {
					$role = User::ROLES[$role];
					$user->assignRole($role);
				}
			}

			defaultUserProfileMediafileCreate($user->id);

			return [
				'message' => 'success',
			];
		} catch (\Exception $e) {
			$request->flash();

			return [
				'message' => 'fail',
				'errors' => [
					$e->getMessage(),
				],
			];
		}
	}

	public function show(User $user)
	{
		try {
			$user = getResourceResponse(
				request(),
				'user',
				'ShowResource',
				$user
			);

			return [
				'message' => 'success',
				'data' => [
					'user' => $user,
				],
			];
		} catch (\Exception $e) {
			return [
				'message' => 'fail',
				'errors' => [
					$e->getMessage(),
				],
			];
		}
	}

	public function edit(User $user)
	{
		try {
			$user = getResourceResponse(
				request(),
				'user',
				'ShowResource',
				$user
			);

			return [
				'message' => 'success',
				'data' => [
					'user' => $user,
				],
			];
		} catch (\Exception $e) {
			return [
				'message' => 'fail',
				'errors' => [
					$e->getMessage(),
				],
			];
		}
	}

	public function update(UpdateUserRequest $request, User $user)
	{
		try {
			$validator = Validator::make(
				$request->all(),
				$request->rules(),
				$request->messages(),
				$request->attributes()
			);

			$messages = [];

			if ($validator->fails()) {
				$request->flash();

				return [
					'message' => 'fail',
					'errors' => $validator->getMessageBag()->all(),
				];
			}

			$validated_data = $validator->validated();

			if (getPrevRouteName() == 'users.profile') {
				if ($user->first_time_login == 1) {
					$validated_data['first_time_login'] = 0;
				}

				if (isset($validated_data['email']) && $validated_data['email'] != $user->email) {
					$validated_data['email'] = $user->email;
					$messages[] = 'Can not update your email as you logged in with it';
				}
			}

			if (isset($validated_data['password'])) {
				$validated_data['password'] = Hash::make($validated_data['password']);
			}

			$user->update($validated_data);

			if ($validated_data['roles'] != null) {
				$roles = [];
				foreach ($validated_data['roles'] as $key => $role) {
					$roles[] = User::ROLES[$role];
				}
				$user->syncRoles($roles);
			}

			return [
				'message' => 'success',
				'messages' => $messages,
			];
		} catch (\Exception $e) {
			$request->flash();

			return [
				'message' => 'fail',
				'errors' => [
					$e->getMessage(),
				],
			];
		}
	}

	public function destroy(User $user)
	{
		try {
			$mediafile_controller = new MediafileController();
			$mediafile_controller->destroyAll(
				$user->id,
				'App\Models\User'
			);

			$user->delete();

			return [
				'message' => 'success',
			];
		} catch (\Exception $e) {
			return [
				'message' => 'fail',
				'errors' => [
					$e->getMessage(),
				],
			];
		}
	}
}
