<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Level;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Mediafile;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
  public function run()
  {
    User::factory()
      ->count(20)
      ->has(
        Mediafile::factory(1),
        'mediafile'
      )
      ->has(
        Subject::factory()
          ->count(3)
          ->has(
            Teacher::factory(1),
            'teacher',
          ),
        'subjects',
      )
      ->create();
  }
}
