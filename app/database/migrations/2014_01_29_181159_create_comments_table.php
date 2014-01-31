<?php

use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("comments", function($table) {
			$table->engine = "InnoDB";

			// IDs
			$table->increments("id");
			$table->integer("news_id")->unsigned();
			$table->integer("user_id")->unsigned()->nullable();

			$table->string("name")->default("Anonymous");
			$table->string("email")->nullable();
			$table->text("comment");

			// tracking
			$table->timestamps();
			$table->softDeletes();
			$table->string("ip");
			$table->boolean("login")->default(false);
			

			// foreign keys
			$table->foreign("user_id")
				->references("id")
				->on("users")
				->onDelete("cascade");

			$table->foreign("news_id")
				->references("id")
				->on("news")
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
		Schema::dropIfExists("comments");
	}

}