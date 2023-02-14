<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
  public function definition()
  {
    return [
      'username' => $this->faker->userName,
      'full_name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
      'status' => $this->faker->randomElement(array_keys(User::STATUS)),
      'gender' => $this->faker->randomElement(array_keys(User::GENDER)),
      'email' => $this->faker->safeEmail,
      'email_verified_at' => $this->faker->dateTime(),
      'phone' => $this->faker->unique()->regexify('^01[0125][0-9]{8}$'),
      'password' => Hash::make('password'),
      'first_time_login' => $this->faker->boolean,
      'remember_token' => Str::random(10),
      'address' => $this->faker->address(),
      'created_at' => $this->faker->dateTime(),
    ];
  }
}
