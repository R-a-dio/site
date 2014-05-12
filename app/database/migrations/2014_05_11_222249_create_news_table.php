<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('radio_news', function (Blueprint $table) {
			$table->engine = "InnoDB";

			$table->increments('id');
			$table->boolean("private")->default(false);
			$table->integer("user_id")->unsigned();

			$table->string("title", 200);
			$table->text("header")->default("");
			$table->text("text")->default("");

			$table->timestamps();
			$table->softDeletes();

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
		Schema::drop('radio_news');
	}

}
