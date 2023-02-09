<?php

namespace App\Sorts;

trait SortUser
{
	protected $allowed_sorts = [
		'id',
		'created_at',
	];

	public function scopeSortUser($query, $sort)
	{
		if (isset($sort['field']) && in_array($sort['field'], $this->allowed_sorts)) {
			$field = $sort['field'] ?? 'id';

			if (isset($sort['order']) && in_array($sort['order'], ['ASC', 'DESC'])) {
				$order = $sort['order'];
			} else {
				$order = 'ASC';
			}

			$query = $query->orderBy($field, $order);
		}

		return $query;
	}
}
