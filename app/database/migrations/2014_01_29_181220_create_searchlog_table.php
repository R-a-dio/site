<?php

use Illuminate\Database\Migrations\Migration;

class CreateSearchlogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("searchlog", function($table) {
			$table->engine = "InnoDB";

			$table->increments("id");
			// Add user ID if logged in.
			$table->integer("user_id")->unsigned()->nullable();

			// searches are max 255 chars
			$table->string("search")->index();

			// hello there NSA
			$table->string("ip");
			$table->timestamp("date");

			$table->foreign("user_id")
				->references("id")
				->on("users")
				// keep user searches
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
		Schema::dropIfExists("searchlog");
	}

}