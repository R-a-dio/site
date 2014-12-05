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
		Schema::create("tracks", function (Blueprint $table) {
            $table->increments("id");

            $table->string("artist", 200);
            $table->string("track", 200); // actually title, blame wessie
            $table->string("album", 200);
            $table->text("path");
            $table->text("tags");
            $table->integer("priority")->default(0);
            $table->string("accepter", 200);
            $table->string("lasteditor", 200);
            $table->timestamp("lastplayed")->nullable();
            $table->timestamp("lastrequested")->nullable();
            $table->string("hash", 40)->unique();
            $table->integer("usable")->default(0);
            $table->integer("requestcount")->default(0);
        });
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
