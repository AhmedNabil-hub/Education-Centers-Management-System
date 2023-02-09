<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('username')->unique()->nullable();
      $table->string('full_name')->nullable();
      $table->tinyInteger('status')->default(array_search('inactive', User::STATUS));
      $table->tinyInteger('gender')->default(array_search('male', User::GENDER));
      $table->string('email')->unique();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('phone')->nullable();
      $table->string('password');
      $table->tinyInteger('first_time_login')->default('1');
      $table->text('address')->nullable();
      $table->rememberToken();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('users');
  }
};
