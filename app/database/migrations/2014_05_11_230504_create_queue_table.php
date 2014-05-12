<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("queue", function (Blueprint $table) {
			$table->engine = "InnoDB";

			$table->increments("id");
			$table->integer("trackid")->unsigned();

			$table->timestamp("time")
				->default(DB::raw("current_timestamp"));
			$table->string("ip", 50);
			$table->integer("type")->unsigned()->nullable();
			$table->string("meta", 200);
			$table->float("length")->nullable()->default(0);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("queue");
	}

}
