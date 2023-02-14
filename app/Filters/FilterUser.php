<?php

namespace App\Filters;

trait FilterUser
{
	public function scopeFilterUser($query, $filters)
	{
		if (isset($filters) && is_array($filters)) {
			foreach ($filters as $filter_key => $filter_value) {
				if ($filter_key == 'id' && isset($filter_value)) {
					$query = $query->where($filter_key, '=', $filter_value);
				} elseif ($filter_key == 'username' && isset($filter_value)) {
					$query = $query->where($filter_key, 'like', $filter_value . '%');
				} elseif ($filter_key == 'full_name' && isset($filter_value)) {
					$query = $query->where($filter_key, 'like', $filter_value . '%');
				} elseif ($filter_key == 'status' && isset($filter_value)) {
					$query = $query->where($filter_key, '=', $filter_value);
				} elseif ($filter_key == 'gender' && isset($filter_value)) {
					$query = $query->where($filter_key, '=', $filter_value);
				} elseif ($filter_key == 'email' && isset($filter_value)) {
					$query = $query->where($filter_key, 'like', $filter_value . '%');
				} elseif ($filter_key == 'phone' && isset($filter_value)) {
					$query = $query->where($filter_key, 'like', $filter_value . '%');
				} elseif ($filter_key == 'address' && isset($filter_value)) {
					$query = $query->where($filter_key, 'like', $filter_value . '%');
				} elseif ($filter_key == 'first_time_login' && isset($filter_value)) {
					$query = $query->where($filter_key, '=', $filter_value);
				} elseif ($filter_key == 'role' && isset($filter_value) && is_array($filter_value)) {
					foreach ($filter_value as $key => $value) {
						$query = $query->whereHas('roles', function ($query) use ($value) {
							$query->where('name', 'like', $value . '%');
						});
					}
				}
			}
		}

		return $query;
	}
}
