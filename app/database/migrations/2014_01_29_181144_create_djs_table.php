<?php

use Illuminate\Database\Migrations\Migration;

class CreateDjsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create("themes", function($table) {
			$table->engine = "InnoDB";

			$table->increments("id");
			$table->string("name")->unique();
			$table->string("creator")->nullable();
			$table->string("colour")->nullable();
			
			// laravel model management
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create("djs", function($table) {
			$table->engine = "InnoDB";

			$table->increments("id");
			$table->string("djname");
			$table->string("djtext"); // no more blog posts allowed
			$table->string("djimage");
			$table->smallInteger("priority")->unsigned();
			$table->string("css"); // obsolete now, will be themes, above
			$table->integer("theme_id")->unsigned();
			$table->string("djcolor"); // obsolete, see above

			// laravel model management
			$table->timestamps();
			$table->softDeletes();

			$table->foreign("theme_id")
				->references("id")
				->on("themes")
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
		Schema::dropIfExists("themes");
		Schema::dropIfExists("djs");
	}

}