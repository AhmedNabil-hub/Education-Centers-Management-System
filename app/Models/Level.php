<?php

namespace App\Models;

use App\Filters\FilterLevel;
use App\Models\User;
use App\Models\Student;
use App\Models\Subject;
use App\Sorts\SortLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
  use HasFactory, FilterLevel, SortLevel;

  protected $fillable = [
    'name',
  ];

  public function students()
  {
    return $this->hasMany(Student::class);
  }

  public function subjects()
  {
    return $this->belongsToMany(
      Subject::class,
      'levels_subjects',
      'level_id',
      'subject_id',
    );
  }

  public function users()
  {
    return $this->belongsToMany(
      User::class,
      'levels_users',
      'level_id',
      'user_id',
    );
  }
}
