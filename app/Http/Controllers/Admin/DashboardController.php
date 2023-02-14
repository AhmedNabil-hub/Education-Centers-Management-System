<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Level;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Resources\Admin\Dashboard\RecentUsersResource;

class DashboardController extends AdminController
{
  public function index()
  {
    $totals_cards = [
      'users'           => number_format(User::count() ?? 0, 0),
      'subjects'        => number_format(Subject::count() ?? 0, 0),
      'teachers'        => number_format(Teacher::count() ?? 0, 0),
      'students'        => number_format(Student::count() ?? 0, 0),
      'levels'          => number_format(Level::count() ?? 0, 0),
    ];

    $recent_users = User::recent()->orderBy('created_at', 'DESC')->limit(10)->get();
    $recent_users = RecentUsersResource::collection($recent_users);

    $users_area_chart_data = $this->prepareAreaChartData('users');
    $students_area_chart_data = $this->prepareAreaChartData('students');

    return view('admin.content.dashboard')
      ->with('totals_cards', $totals_cards ?? [])
      ->with('recent_users', $recent_users ?? [])
      ->with('users_area_chart_data', $users_area_chart_data ?? [])
      ->with('students_area_chart_data', $students_area_chart_data ?? []);
  }

  public function prepareAreaChartData($table)
  {
    $data_per_month = DB::table($table)
    ->select([
      DB::raw("(COUNT(id)) as {$table}_count"),
      DB::raw("(DATE_FORMAT(created_at, '%b')) as month"),
    ])
      // ->whereYear('created_at', now()->year)
      ->groupBy(DB::raw("(DATE_FORMAT(created_at, '%b'))"))
      ->orderBy(DB::raw("(DATE_FORMAT(created_at, '%b'))"), 'ASC')
      ->get();

    $chart_data = [
      'Jan' => 0,
      'Feb' => 0,
      'Mar' => 0,
      'Apr' => 0,
      'May' => 0,
      'Jun' => 0,
      'Jul' => 0,
      'Aug' => 0,
      'Sep' => 0,
      'Oct' => 0,
      'Nov' => 0,
      'Dec' => 0,
    ];

    foreach ($data_per_month as $month) {
      $count_name = "{$table}_count";
      $chart_data[$month->month] = $month->$count_name;
    }

    return $chart_data;
  }
}
