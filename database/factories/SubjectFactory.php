<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
  public function definition()
  {
    return [
      'name' => $this->faker->name(),
      // 'user_id' => '',
    ];
  }
}
