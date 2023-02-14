<?php

namespace App\Models;

use App\Filters\FilterSubject;
use App\Models\User;
use App\Models\Level;
use App\Models\Student;
use App\Models\Teacher;
use App\Sorts\SortSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
  use HasFactory, FilterSubject, SortSubject;

  protected $fillable = [
    'name',
    'user_id',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function teacher()
  {
    return $this->hasOne(Teacher::class);
  }

  public function students()
  {
    return $this->belongsToMany(
      Student::class,
      'students_subjects',
      'subject_id',
      'student_id',
    );
  }

  public function levels()
  {
    return $this->belongsToMany(
      Level::class,
      'levels_subjects',
      'subject_id',
      'level_id',
    );
  }
}
