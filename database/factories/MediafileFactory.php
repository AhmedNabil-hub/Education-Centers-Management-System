<?php

namespace Database\Factories;

use App\Models\Mediafile;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediafileFactory extends Factory
{
	public function definition()
	{
		$model_type = $this->faker->randomElement(Mediafile::MODEL_TYPE);
		// $type = $this->faker->randomElement(array_keys(Mediafile::TYPE));

		$path = 'uploads/' . $model_type . "/profile_image/" . Mediafile::DEFAULT_IMAGE_NAME[$model_type];

		return [
			'path' => $path,
			'type' => 'profile_image',
			'model_id' => $this->faker->randomNumber(1),
			'model_type' => $model_type,
			'is_default' => 1,
		];
	}
}

