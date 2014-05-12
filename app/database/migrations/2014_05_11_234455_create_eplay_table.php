<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEplayTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("eplay", function (Blueprint $table) {
			$table->engine = "InnoDB";

			$table->increments("id");
			$table->integer("isong")->unsigned();
			$table->timestamp("dt")
				->default(DB::raw("current_timestamp"));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("eplay");
	}

}