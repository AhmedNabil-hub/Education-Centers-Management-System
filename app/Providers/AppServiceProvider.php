<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    Relation::enforceMorphMap([
      'user' => 'App\Models\User',
    ]);

    LengthAwarePaginator::useBootstrap();

    Blade::if('notfirsttime', function () {
      return auth()->user() && auth()->user()->first_time_login == 0;
    });
  }
}
