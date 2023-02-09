<?php

namespace App\Filters;

trait FilterUser
{
	public function scopeFilterUser($query, $filters)
	{
		if (isset($filters) && is_array($filters)) {
			foreach ($filters as $key => $value) {
				if ($key == 'id' && isset($value)) {
					$query = $query->where($key, '=', $value);
				} elseif ($key == 'username' && isset($value)) {
					$query = $query->where($key, 'like', $value . '%');
				} elseif ($key == 'full_name' && isset($value)) {
					$query = $query->where($key, 'like', $value . '%');
				} elseif ($key == 'status' && isset($value)) {
					$query = $query->where($key, '=', $value);
				} elseif ($key == 'gender' && isset($value)) {
					$query = $query->where($key, '=', $value);
				} elseif ($key == 'email' && isset($value)) {
					$query = $query->where($key, 'like', $value . '%');
				} elseif ($key == 'phone' && isset($value)) {
					$query = $query->where($key, 'like', $value . '%');
				} elseif ($key == 'address' && isset($value)) {
					$query = $query->where($key, 'like', $value . '%');
				} elseif ($key == 'first_time_login' && isset($value)) {
					$query = $query->where($key, '=', $value);
				} elseif ($key == 'role' && isset($value) && is_array($value)) {
					foreach ($value as $index => $role) {
						$query = $query->whereHas('roles', function ($query) use ($role) {
							$query->where('name', 'like', $role . '%');
						});
					}
				}
			}
		}

		return $query;
	}
}
