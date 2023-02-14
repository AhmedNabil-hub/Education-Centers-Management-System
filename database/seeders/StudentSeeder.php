<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
  public function run()
  {
    $users = User::all();

    foreach ($users as $user) {
      Student::factory()
        ->count(20)
        ->for($user)
        ->state(['level_id' => $user->levels->random()->id])
        ->create();
    }
  }
}
