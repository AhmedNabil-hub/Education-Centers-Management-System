<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LevelSubjectSeeder extends Seeder
{
  public function run()
  {
    $subjects = Subject::all();
    $levels = Level::all();

    foreach ($subjects as $subject) {
      foreach ($levels->random(3) as $level) {
        DB::insert(
          'insert into levels_subjects (subject_id, level_id) values (?, ?)',
          [$subject->id, $level->id]
        );
      }
    }
  }
}
