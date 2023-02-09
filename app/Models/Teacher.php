<?php

namespace App\Models;

use App\Models\User;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
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

  public function subject()
  {
    return $this->hasOne(Subject::class);
  }
}
