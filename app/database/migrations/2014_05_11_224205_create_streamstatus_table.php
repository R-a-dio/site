<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreamstatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("streamstatus", function (Blueprint $table) {
			$table->engine = "InnoDB";

			$table->increments("id");
			$table->integer("djid")->unsigned();
			$table->string("djname")->nullable();
			$table->string("np", 200);

			$table->integer("listeners")->unsigned();
			$table->integer("bitrate")->unsigned()->default(0);

			$table->boolean("isafkstream")->default(0);
			$table->boolean("requesting")->default(false);
			$table->boolean("isstreamdesk")->default(false);

			// 64-bit ints for times
			$table->bigInteger("start_time")->unsigned();
			$table->bigInteger("end_time")->unsigned();

			$table->integer("trackid")->unsigned()->nullable();

			$table->foreign("djid")
				->references("id")
				->on("djs");

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("streamstatus");
	}

}
