<?php

class ImportController extends BaseController {

	//eng-GNBDC

	public $version;

	public function __construct($version='eng-KJVA') {		
		$this->version = $version;
	}

	public function importBooks() {

		$api = new BiblesApi();
		$version = $this->version;
		$books = $api->getBooks($version);
		$books = $books->response->books;
		foreach ($books as $book) {
			$version = explode(':',$book->id)[0];
			$record = Book::firstOrNew(array('version' => $version, 'abbreviation' => $book->abbr));
			$record->name = $book->name;
			$record->abbreviation = $book->abbr;
			$record->order = $book->ord;
			$record->original_id = $book->id;
			$record->version = $version;
			$record->testament = $book->testament;
			$last_bits = explode('.',$book->osis_end);
			$record->end_chapter = $last_bits[1];
			$record->end_verse = $last_bits[2];

			$record->save();
		}

		return View::make('data')
			->with('result','Books have been updated for version '.$version);

	}


	public function importHeadings() {

		$books = Book::where('version',$this->version)
			//->where('order','>','41')
			->orderBy('order','ASC')
			->get();
		foreach ($books as $book) {
			$this->importBookHeadings($book,$this->version);
		}

	}

	private function importBookHeadings($book_obj,$version='eng-GNBDC') {
		$book = $book_obj->abbreviation;
		echo '**** BEGINNING: '.$book.' *******';
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

			if (!isset($passage->response->search->result->passages[0])) {
				continue;
			}
			$result = $passage->response->search->result->passages[0]->text;
			$html = new Htmldom($result);
			
			// Find all images 


			$elements = $html->find('h3,sup');
			
			foreach ($elements as $element) {
		       if ($element->class=='s1') {

			       	if (isset($heading) && is_object($heading)) {
			       		//finish up last round;
				       	$heading->end_chapter = $previous_chapter;
				       	$heading->end_verse = $previous_verse;
				       	$heading->save();
				       	echo $heading->heading_text.'|'.$book.'|'.$heading->start_chapter.':'.$heading->start_verse.'|'
				       		.$heading->end_chapter.':'.$heading->end_verse.'|'.PHP_EOL;
				       	$previous_chapter = '';
				       	$previous_verse = '';
				    }
			
			       	$heading = Heading::firstOrNew(array('version' => $version, 'book' => $book, 
			       			'start_chapter'=>$chapter, 'start_verse'=>$verse_num+1));
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
		       		
		       		$previous_verse = count($verse_num)>1 ? intval($verse_num[1]) : intval($verse_num[0]);
		       		$verse_num = intval($verse_num[0]);

		       		$previous_chapter = $chapter;

		       }
				
		    }

		    
		}
		if (!isset($heading)) {
			$heading = Heading::firstOrNew(array('version' => $version, 'book' => $book, 
				       			'start_chapter'=>1, 'start_verse'=>1));
	       	$heading->book = $book;
	       	$heading->start_chapter = 1;
	       	$heading->start_verse = 1;
	       	$heading->version = $version;
	       	$heading->order = 1;
	       	$heading->book_order = 1;
	       	$heading->chapter_order = 1;
	       	$heading->heading_text = $book_obj->name;
	       	
	       	$heading_order++;
	       	$heading_book_order++;
	       	$heading_chapter_order++;

		}
		
   		//finish up end of  book
       	$heading->end_chapter = $previous_chapter;
       	$heading->end_verse = $previous_verse;
       	$heading->save();
       	echo $heading->heading_text.'|'.$book.'|'.$heading->start_chapter.':'.$heading->start_verse.'|'
				       		.$heading->end_chapter.':'.$heading->end_verse.'|'.PHP_EOL;
		 $verse = 0;
		return View::make('data')
			->with('result','Bible import finished for version '.$version);

	}

	

}
