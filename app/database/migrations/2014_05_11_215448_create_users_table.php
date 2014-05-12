<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("users", function (Blueprint $table) {
			$table->engine = "InnoDB";

			$table->increments("id");
			$table->string("user", 50);
			$table->integer("privileges");

			$table->string("pass")->nullable();
			$table->string("email")->nullable();

			$table->timestamps();
			$table->softDeletes();

			$table->integer("djid")
				->unsigned()
				->nullable();

			$table->foreign("djid")
				->references("id")
				->on("djs")
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
		Schema::drop("users");
	}

}
