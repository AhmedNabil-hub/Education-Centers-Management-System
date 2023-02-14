<?php

namespace App\Models;

use App\Filters\FilterTeacher;
use App\Models\User;
use App\Models\Subject;
use App\Sorts\SortTeacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
  use HasFactory, FilterTeacher, SortTeacher;

  protected $fillable = [
    'name',
    'subject_id',
  ];

  public function subject()
  {
    return $this->belongsTo(Subject::class);
  }
}
