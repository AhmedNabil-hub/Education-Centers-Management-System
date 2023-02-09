<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mediafile extends Model
{
	use HasFactory;

	protected $fillable = [
		'path',
		'type',
		'model_id',
		'model_type',
		'is_default',
	];

	const TYPE = [
		'profile_image' => [
			'width' => '500',
			'height' => '500',
			'ext' => 'jpg',
		],
	];

	const MODEL_TYPE = [
		'user',
	];

	const DEFAULT_IMAGE_NAME = [
		'user'  => 'default_user.svg',
	];

	public function mediafileable()
	{
		return $this->morphTo(__FUNCTION__, 'model_type', 'model_id');
	}
}
