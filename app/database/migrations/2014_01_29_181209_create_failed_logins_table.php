<?php

use Illuminate\Database\Migrations\Migration;

class CreateFailedLoginsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("failed_logins", function($table) {
			$table->engine = "InnoDB";

			$table->increments("id");
			$table->string("username");
			$table->string("ip");
			$table->timestamp("date");
			$table->string("password"); // sha256 hashed password, helps detect duplicates/diagnose shit without leaking
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("failed_logins");
	}

}