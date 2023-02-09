<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;

class DashboardController extends AdminController
{
  public function index()
  {
    $totals = [
      'users' => number_format(User::count() ?? 0, 0),
    ];

    return view('admin.content.dashboard')
      ->with('totals', $totals ?? []);
  }
}
