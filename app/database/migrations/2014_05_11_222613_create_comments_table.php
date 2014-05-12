<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('radio_comments', function (Blueprint $table)
		{
			$table->engine = "InnoDB";

			$table->increments('id');

			$table->integer("user_id")
				->unsigned()
				->nullable();

			$table->integer("news_id")
				->unsigned();

			$table->string("comment", 500);
			$table->string("ip", 50)->nullable();

			$table->timestamps();
			$table->softDeletes();

			$table->foreign("user_id")
				->references("id")
				->on("users")
				->onDelete("cascade");

			$table->foreign("news_id")
				->references("id")
				->on("radio_news")
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
		Schema::drop('radio_comments');
	}

}
