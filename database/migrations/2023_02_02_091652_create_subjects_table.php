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
    Schema::create('subjects', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->unsignedBigInteger('user_id');
      $table->unsignedBigInteger('teacher_id');
      $table->json('levels');
      $table->timestamps();

      $table->foreign('user_id')
      ->references('id')
      ->on('users')
      ->onUpdate('cascade')
      ->onDelete('cascade');

      $table->foreign('teacher_id')
      ->references('id')
      ->on('teachers')
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
    Schema::dropIfExists('subjects');
  }
};
