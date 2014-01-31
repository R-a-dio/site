<?php

use Illuminate\Database\Migrations\Migration;

class CreateTracksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("tracks", function($table) {
			$table->engine = "InnoDB";

			$table->increments("id");
			$table->string("artist");
			$table->string("track");
			$table->string("album");
			$table->string("path");
			$table->string("tags");
			$table->smallInteger("priority")->unsigned();

			$table->boolean("need_reupload")->default(false);
			$table->boolean("usable")->default(false);
			
			$table->string("hash")->unique();
			$table->integer("requestcount")->unsigned();

			$table->timestamp("lastplayed");
			$table->timestamp("lastrequested");

			// current (shitty) link between songs and acceptors
			$table->string("accepter")->default("");
			$table->string("lasteditor")->default("");

			// ACTUALLY make a fucking link between songs and acceptors
			$table->integer("acceptor_id")->unsigned()->nullable();
			$table->integer("editor_id")->unsigned()->nullable();


		});

		// FULLTEXT index
		DB::statement("alter table `tracks` add fulltext `searchindex` (`artist`, `tags`, `track`, `album`)");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("tracks");
	}

}