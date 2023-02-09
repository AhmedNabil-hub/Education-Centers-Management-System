<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'user_id',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
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
