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
		Schema::create('mediafiles', function (Blueprint $table) {
			$table->id();
			$table->string('path');
			$table->string('type')->default('profile_image');
			$table->unsignedBigInteger('model_id');
			$table->string('model_type');
			$table->boolean('is_default')->default(true);
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
		Schema::dropIfExists('mediafiles');
	}
};
