<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Heading extends Eloquent {

	protected $fillable = array('book','start_chapter','start_verse','end_chapter','end_verse',
		'heading_text','version','order','book_order','chapter_order');

	public $order;

	use SoftDeletingTrait;

	public function __construct() {

		//$book = Book::where('abbreviation',$this->book)->first();
		//$this->order = $book->order;

	}

	public function book_obj()
    {
        return $this->belongsTo('Book','book','abbreviation')
        	;
    }

}