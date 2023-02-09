<?php

namespace Database\Seeders;


use App\Models\User;
use App\Models\Mediafile;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
	public function run()
	{
		$this->call(
			[
				PermissionSeeder::class,
				UserSeeder::class,
			]
		);

		$user = User::create([
			'username' => 'ahmednabil',
			'full_name' => 'Ahmed Nabil',
			'status' => 2,
			'gender' => 1,
			'email' => 'an@test.com',
			'email_verified_at' => now(),
			'phone' => null,
			'password' => Hash::make('password'),
			'first_time_login' => 0,
			'remember_token' => Str::random(10),
		]);

		Mediafile::create([
			'path' => 'uploads/user/profile_image/default_user.svg',
			'type' => 'profile_image',
			'model_type' => 'user',
			'model_id' => $user->id,
			'is_default' => true,
		]);

		$user->assignRole(['admin', 'main']);

		DB::table('mediafiles')
			->where('model_type', 'user')
			->update(['path' => 'uploads/user/profile_image/default_user.svg']);
	}
}
