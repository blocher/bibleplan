<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Heading extends Eloquent {

	protected $fillable = array('book','chapter','verse','heading_text','version','order','book_order','chapter_order');

	use SoftDeletingTrait;

}