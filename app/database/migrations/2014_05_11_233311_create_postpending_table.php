<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostpendingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('postpending', function (Blueprint $table) {
			$table->increments('id');
			$table->integer("trackid")->unsigned()->nullable();

			$table->string("meta", 200);
			$table->string("ip", 50);
			$table->string("reason")->nullable();

			$table->boolean("accepted");
			$table->boolean("good_upload")->default(0)->nullable();

			$table->timestamp("time")->default(DB::raw("current_timestamp"));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('postpending');
	}

}
