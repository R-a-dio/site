<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pending', function (Blueprint $table) {
			$table->engine = "InnoDB";

			$table->increments("id");

			$table->string("artist");
			$table->string("track");
			$table->string("album");
			$table->string("path");
			$table->string("comment");
			$table->string("origname");
			$table->string("submitter");

			$table->string("format", 10)->nullable()->default("mp3");
			$table->string("mode", 10)->nullable()->default("cbr");
			
			$table->integer("bitrate")->unsigned()->nullable();
			$table->integer("replacement")->unsigned()->nullable();
			$table->float("length")->nullable()->default(0);
			$table->boolean("dupe_flag");

			$table->timestamp("submitted")
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
		Schema::drop('pending');
	}

}
