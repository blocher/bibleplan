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
			$version = explode(':',$book->id)[0];
			$record = Book::firstOrNew(array('version' => $version, 'abbreviation' => $book->abbr));
			$record->name = $book->name;
			$record->abbreviation = $book->abbr;
			$record->order = $book->ord;
			$record->original_id = $book->id;
			$record->version = $version;
			$last_bits = explode('.',$book->osis_end);
			$record->end_chapter = $last_bits[1];
			$record->end_verse = $last_bits[2];

			$record->save();
		}

		return View::make('data')
			->with('result','Books have been updated for version '.$version);

	}


	public function getChapters($book='Gen',$version='eng-GNBDC') {

		$book_obj = Book::where('abbreviation',$book)
			->where('version',$version)
			->first();
		$end_chapter = $book_obj->end_chapter;

		$headings = [];
		for ($chapter=1; $chapter<=$end_chapter; $chapter++) {
			$verse = 1;
			$api = new BiblesApi();
			$passage = $api->getPassage($book.' '.$chapter,$version);
			$result = $passage->response->search->result->passages[0]->text;
			$html = new Htmldom($result);

			// Find all images 
			foreach($html->find('h3,sup') as $element) {
		       if ($element->class=='s1') {
		       	$headings[] = [
		       		'text' => $element->plaintext,
		       		'chapter' => $chapter,
		       		'verse' => $verse,
		       	];
		       } else {
		       	$verse++;
		       }
			}
		}
		pp($headings);
		return View::make('data')
			->with('result',$result);

	}

	

}
