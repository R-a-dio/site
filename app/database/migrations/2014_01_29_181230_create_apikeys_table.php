<?php

use Illuminate\Database\Migrations\Migration;

class CreateApikeysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("api_keys", function($table) {
			$table->engine = "InnoDB";

			$table->increments("id");
			$table->integer("user_id")->unsigned();
			$table->string("key")->index();

			$table->foreign("user_id")
				->references("id")
				->on("users")
				->onDelete("cascade");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("api_keys");
	}

}