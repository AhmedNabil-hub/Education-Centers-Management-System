<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mediafile;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
  public function run()
  {
    User::factory()
      ->count(50)
      ->has(
        Mediafile::factory(1),
        'mediafile'
      )
      ->create();
  }
}
