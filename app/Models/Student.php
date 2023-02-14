<?php

namespace App\Models;

use App\Filters\FilterStudent;
use App\Models\User;
use App\Models\Level;
use App\Models\Subject;
use App\Sorts\SortStudent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
  use HasFactory, FilterStudent, SortStudent;

  protected $fillable = [
    'name',
    'user_id',
    'level_id',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function level()
  {
    return $this->belongsTo(Level::class);
  }

  public function subjects()
  {
    return $this->belongsToMany(
      Subject::class,
      'students_subjects',
      'student_id',
      'subject_id',
    );
  }
}
