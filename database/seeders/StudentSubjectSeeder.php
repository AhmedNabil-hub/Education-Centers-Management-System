<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSubjectSeeder extends Seeder
{
  public function run()
  {
    $students = Student::all();

    foreach ($students as $student) {
      $subjects = Subject::query()
        ->whereRelation('levels', 'levels.id', '=', $student->level->id)
        ->get();

      foreach ($subjects->random(3) as $subject) {
        DB::insert(
          'insert into students_subjects (student_id, subject_id) values (?, ?)',
          [$student->id, $subject->id]
        );
      }
    }
  }
}
