<?php

class ImportController extends BaseController {

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
	//eng-GNBDC
	public function importBooks() {

		$api = new BiblesApi();
		$books = $api->getBooks('eng-KJVA');
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


	public function importHeadings($book='Gen',$version='eng-GNBDC') {
		echo 'beginning';
		$heading_order = 1;
		$heading_book_order = 1;
		$heading_chapter_order = 1;
		$verse_order = 1;

		$book_obj = Book::where('abbreviation',$book)
			->where('version',$version)
			->first();
		$end_chapter = $book_obj->end_chapter;

		$headings = [];
		

		$previous_verse = '';
		$previous_chapter = '';
		for ($chapter=1; $chapter<=$end_chapter; $chapter++) {
			$chapter_book_order = 1;
		
			$verse_num = 0;
			
			$api = new BiblesApi();
			$passage = $api->getPassage($book.' '.$chapter,$version);
			$result = $passage->response->search->result->passages[0]->text;
			$html = new Htmldom($result);
			
			// Find all images 

			$elements = $html->find('h3');
			if (count($elements)>0) {

				$elements = $html->find('h3,sup');
				
				foreach ($elements as $element) {
			       if ($element->class=='s1') {

				       	if (isset($heading) && is_object($heading)) {
				       		//finish up last round;
					       	$heading->end_chapter = $previous_chapter;
					       	$heading->end_verse = $previous_verse;
					       	$heading->save();
					       	echo $heading->heading_text.'|'.$heading->start_chapter.':'.$heading->start_verse.'|'
					       		.$heading->end_chapter.':'.$heading->end_verse.'|'.PHP_EOL;
					       	$previous_chapter = '';
					       	$previous_verse = '';
					    }

				       	$heading = Heading::firstOrNew(array('version' => $version, 'book' => $book, 'start_chapter'=>$chapter, 'start_verse'=>$verse_num));
				       	$heading->book = $book;
				       	$heading->start_chapter = $chapter;
				       	$heading->start_verse = $verse_num+1;
				       	$heading->version = $version;
				       	$heading->order = $heading_order;
				       	$heading->book_order = $heading_book_order;
				       	$heading->chapter_order = $heading_chapter_order;
				       	$heading->heading_text = $element->plaintext;
				       	
				       	$heading_order++;
				       	$heading_book_order++;
				       	$heading_chapter_order++;

			       } else {

			       		$verse_num = $element->plaintext;
			       		$verse_num = explode('-',$verse_num);
			       		$verse_num = intval($verse_num[0]);
			       		$previous_verse = $verse_num;
			       		$previous_chapter = $chapter;

			       }
				}

				
		    }

		    
		}

		if (is_object($heading)) {
       		//finish up end of  book
	       	$heading->end_chapter = $previous_chapter;
	       	$heading->end_verse = $previous_verse;
	       	$heading->save();
	       	echo $heading->heading_text.'|'.$heading->start_chapter.':'.$heading->start_verse.'|'
					       		.$heading->end_chapter.':'.$heading->end_verse.'|'.PHP_EOL;
	     }
		 $verse = 0;
		return View::make('data')
			->with('result','Bible import finished for version '.$version);

	}

	

}
