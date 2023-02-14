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
    Schema::create('levels_subjects', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('level_id')->nullable();
      $table->unsignedBigInteger('subject_id')->nullable();
      $table->timestamps();

      $table->foreign('level_id')
      ->references('id')
      ->on('levels')
      ->onUpdate('cascade')
      ->onDelete('cascade');

      $table->foreign('subject_id')
      ->references('id')
      ->on('subjects')
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
    Schema::dropIfExists('levels_subjects');
  }
};
