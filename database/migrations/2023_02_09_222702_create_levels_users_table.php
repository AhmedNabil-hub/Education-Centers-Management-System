<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('levels_users', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('level_id')->nullable();
      $table->unsignedBigInteger('user_id')->nullable();
      $table->timestamps();

      $table->foreign('level_id')
      ->references('id')
      ->on('levels')
      ->onUpdate('cascade')
      ->onDelete('cascade');

      $table->foreign('user_id')
      ->references('id')
      ->on('users')
      ->onUpdate('cascade')
      ->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('levels_users');
  }
};
