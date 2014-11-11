<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('books', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('abbreviation');
			$table->smallInteger('order')->unsigned();
			$table->smallInteger('catholic_order')->unsigned()->nullable();
			$table->string('testament');
			$table->string('original_id')->nullable();
			$table->smallInteger('end_chapter')->unsigned();
			$table->smallInteger('end_verse')->unsigned();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('books');
	}

}
