<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Book extends Eloquent {

	protected $fillable = array('name','abbreviation','order','catholic_order','testament','original_id','version','end_chapter','end_verse');

	use SoftDeletingTrait;

}