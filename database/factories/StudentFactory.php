<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
  public function definition()
  {
    return [
      'name' => $this->faker->name(),
      'created_at' => $this->faker->dateTime(),
      // 'user_id' => '',
      // 'level_id' => '',
    ];
  }
}
