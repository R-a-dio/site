<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTracksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tracks', function (Blueprint $table) {
			$table->engine = "InnoDB";

			$table->increments("id");

			$table->string("artist");
			$table->string("track");
			$table->string("album");
			$table->string("tags");

			$table->string("path");

			// old way
			$table->string("accepter");
			$table->string("lasteditor");

			// newer way of doing it...
			$table->integer("acceptor_id")->unsigned()->nullable();
			$table->integer("editor_id")->unsigned()->nullable();

			// unique key (metadata hash)
			$table->string("hash", 40)->unique();

			// song_delay calc variable
			$table->integer("priority")->default(0);

			// timestamps
			$table->timestamp("lastplayed");
			$table->timestamp("lastrequested");

			$table->boolean("need_reupload")->default(0);
			$table->boolean("usable")->default(0);

			$table->foreign("acceptor_id")
				->references("id")
				->on("users")
				->onDelete("set null");

			$table->foreign("editor_id")
				->references("id")
				->on("users")
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
		Schema::drop("tracks");
	}

}