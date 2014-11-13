<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeadingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('headings', function(Blueprint $table) {
			$table->increments('id');
			$table->string('book');
			$table->smallInteger('chapter')->unsigned();
			$table->smallInteger('verse')->unsigned();
			$table->longText('heading_text');
			$table->string('version');
			$table->integer('order')->unsigned();
			$table->integer('book_order')->unsigned();
			$table->integer('chapter_order')->unsigned();
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
		Schema::drop('headings');
	}

}
