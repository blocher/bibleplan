<?php

class DataController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function getBooks() {

		$api = new BiblesApi();
		$books = $api->getBooks('eng-GNBDC');
		$books = $books->response->books;
		foreach ($books as $book) {
			
			$record = new Book();
			$record->name = $book->name;
			$record->abbreviation = $book->abbr;
			$record->order = $book->ord;
			$record->original_id = $book->id;
			$last_bits = explode('.',$book->osis_end);
			$record->end_chapter = $last_bits[1];
			$record->end_verse = $last_bits[2];

			$record->save();
		}

	}

}
