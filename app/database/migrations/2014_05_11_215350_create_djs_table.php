<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDjsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("djs", function (Blueprint $table) {
			$table->engine = "InnoDB";

			$table->increments("id");
			$table->string("djname", 30);
			$table->string("djimage", 100);
			$table->boolean("visible", false);
			$table->integer("priority");
			$table->string("role", 100);

			$table->integer("theme_id")->unsigned()->nullable();

			$table->foreign("theme_id")
				->references("id")
				->on("themes")
				->onDelete("set null");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("djs");
	}

}
