<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Level;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LevelUserSeeder extends Seeder
{
  public function run()
  {
    $users = User::all();
    $levels = Level::all();

    foreach ($users as $user) {
      foreach ($levels->random(3) as $level) {
        DB::insert(
          'insert into levels_users (user_id, level_id) values (?, ?)',
          [$user->id, $level->id]
        );
      }
    }
  }
}
