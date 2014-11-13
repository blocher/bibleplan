<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Verse extends Eloquent {

	protected $fillable = array('book','chapter','verse','text','version','order');

	use SoftDeletingTrait;

}