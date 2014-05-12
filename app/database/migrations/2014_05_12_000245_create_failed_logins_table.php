<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFailedLoginsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('failed_logins', function (Blueprint $table) {
			$table->engine = "InnoDB";

			$table->increments('id');
			$table->string("ip", 50);

			$table->string("user");
			$table->string("password");

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
		Schema::drop('failed_logins');
	}

}
