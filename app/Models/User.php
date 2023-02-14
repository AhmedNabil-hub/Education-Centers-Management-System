<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Filters\FilterUser;
use App\Models\Student;
use App\Models\Subject;
use App\Sorts\SortUser;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable, HasRoles, FilterUser, SortUser;

  protected $fillable = [
    'username',
    'full_name',
    'status',
    'gender',
    'email',
    'email_verified_at',
    'phone',
    'password',
    'first_time_login',
    'address',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  const STATUS = [
    1 => 'inactive',
    2 => 'active',
  ];

  const GENDER = [
    1 => 'male',
    2 => 'female',
  ];

  const SORT_ORDERS = [
    1 => 'ASC',
    2 => 'DESC',
  ];

  const SORT_FIELDS = [
    1 => 'id',
    3 => 'created_at',
  ];

  const ROLES = [
    1 => 'main',
    2 => 'admin',
  ];

  public function scopeActive($query)
  {
    $query->where('status', array_search('active', $this::STATUS));
  }

  public function scopeRecent($query)
  {
    $query->where('created_at', '>=', Carbon::now()->subDays(29));
  }

  public function mediafile()
  {
    return $this->morphOne(
      Mediafile::class,
      'mediafileable',
      'model_type',
      'model_id'
    );
  }

  public function students()
  {
    return $this->hasMany(Student::class);
  }

  public function subjects()
  {
    return $this->hasMany(Subject::class);
  }

  public function levels()
  {
    return $this->belongsToMany(
      Level::class,
      'levels_users',
      'user_id',
      'level_id',
    );
  }
}
