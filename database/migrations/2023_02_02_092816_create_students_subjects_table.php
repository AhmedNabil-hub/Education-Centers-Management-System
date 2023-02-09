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
    Schema::create('students_subjects', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('subject_id');
      $table->unsignedBigInteger('student_id');
      $table->timestamps();

      $table->foreign('subject_id')
      ->references('id')
      ->on('subjects')
      ->onUpdate('cascade')
      ->onDelete('cascade');

      $table->foreign('student_id')
      ->references('id')
      ->on('students')
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
    Schema::dropIfExists('students_subjects');
  }
};
