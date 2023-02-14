<?php

namespace App\Filters;

trait FilterStudent
{
	public function scopeFilterStudent($query, $filters)
	{
		if (isset($filters) && is_array($filters)) {
			foreach ($filters as $filter_key => $filter_value) {
				if ($filter_key == 'id' && isset($filter_value)) {
					$query = $query->where($filter_key, '=', $filter_value);
				} elseif ($filter_key == 'name' && isset($filter_value)) {
					$query = $query->where($filter_key, 'like', $filter_value . '%');
				}
			}
		}

		return $query;
	}
}
