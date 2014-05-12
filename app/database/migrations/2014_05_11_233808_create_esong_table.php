<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsongTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('esong', function(Blueprint $table) {
			$table->engine = "InnoDB";

			$table->increments("id");
			$table->string("hash", 40)->unique();
			$table->string("hash_link", 40);
			$table->integer("len")->unsigned();
			$table->string("meta", 200);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("esong");
	}

}