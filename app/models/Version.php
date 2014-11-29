<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Version extends Eloquent {

	protected $fillable = array('name','abbreviation','source');

	use SoftDeletingTrait;

	public function books()
    {
        return $this->hasMany('Book','abbreviation','book')
        	->orderBy('order', 'ASC');
    }

}