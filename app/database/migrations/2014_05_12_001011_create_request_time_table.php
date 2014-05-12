<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestTimeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('requesttime', function (Blueprint $table) {
			$table->increments('id');
			$table->string("ip", 50);
			$table->timestamp("time")
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
		Schema::drop('requesttime');
	}

}
