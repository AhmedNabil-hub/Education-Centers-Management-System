<?php

namespace App\Models;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'user_id',
    'teacher_id',
    'levels',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function teacher()
  {
    return $this->belongsTo(Teacher::class);
  }

  public function students()
  {
    return $this->belongsToMany(Student::class);
    return $this->belongsToMany(
      Student::class,
      'students_subjects',
      'subject_id',
      'student_id',
    );
  }
}
