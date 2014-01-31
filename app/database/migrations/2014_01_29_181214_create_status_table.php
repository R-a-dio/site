<?php

use Illuminate\Database\Migrations\Migration;

class CreateStatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("streamstatus", function($table) {
			$table->engine = "InnoDB";

			$table->increments("id");
			$table->integer("djid")->unsigned()->default(0);
			$table->string("np")->default("");
			$table->integer("listeners")->unsigned()->default(0);
			$table->integer("bitrate")->unsigned()->default(0);
			$table->boolean("isafkstream")->default(false);
			$table->bigInteger("start_time")->default(0);
			$table->bigInteger("end_time")->default(0);

			$table->timestamp("last_set")
				->default(DB::raw("current_timestamp on update current_timestamp"));

			$table->integer("trackid")->unsigned()->nullable();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("streamstatus");
	}

}