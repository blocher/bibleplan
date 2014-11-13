<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVersesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('verses', function(Blueprint $table) {
			$table->increments('id');
			$table->string('book');
			$table->smallInteger('chapter')->unsigned();
			$table->smallInteger('verse')->unsigned();
			$table->longText('verse_text');
			$table->string('version');
			$table->integer('order')->unsigned();
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
		Schema::drop('verses');
	}

}
