<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("users", function ($table) {
			$table->engine = "InnoDB";

			$table->increments("id");
			$table->string("user")->unique();
			$table->string("pass");
			$table->string("email")->nullable();
			$table->integer("djid")->unsigned()->nullable();

			$table->mediumInteger("privileges")->default(0);
			$table->timestamps();
			$table->softDeletes();

			// vin, wessie: you're retarded for doing it this way around
			$table->foreign("djid")
				->references("id")
				->on("djs")
				->onDelete("no action");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("users");
	}

}