<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStaffTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('staff', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 50);
			$table->string('title', 50)->nullable();
			$table->string('photo', 50)->nullable();
			$table->string('email', 50)->unique();
			$table->string('phone', 50);
			$table->string('website', 50)->nullable();
			$table->string('description')->nullable();
			$table->unsignedInteger('school_id');
			$table->foreign('school_id')->references('id')->on('schools');
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
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		Schema::dropIfExists('staff');
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}
