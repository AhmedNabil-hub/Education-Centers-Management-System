<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
	public function run()
	{
		$admin_permissions = [];
		$main_permissions = [];

		$permissions = generatePermissionsNames();

		foreach ($permissions['admin'] as $permission) {
			$admin_permissions[] = ['name' => 'admin-'.$permission, 'guard_name' => 'web'];
		}

		foreach ($permissions['main'] as $permission) {
			$main_permissions[] = ['name' => 'main-'.$permission, 'guard_name' => 'web'];
		}

		Permission::insert($admin_permissions);
		Permission::insert($main_permissions);

		$admin_role = Role::create(['name' => 'admin']);
		$main_role = Role::create(['name' => 'main']);

		$admin_role->syncPermissions(Arr::pluck($admin_permissions, 'name'));
		$main_role->syncPermissions(Arr::pluck($main_permissions, 'name'));
	}
}
