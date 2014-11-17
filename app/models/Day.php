<?php

class Day  {


	protected $start_chapter;
	protected $start_verse;

	protected $end_chapter;
	protected $end_verse;

	protected $headings;

	public function __construct($headings) {

		$this->headings = $headings;
		$first = array_shift($headings);
		$last = array_pop($headings);
	
		$this->start_chpater = $first->start_chapter;
		$this->start_verse = $first->start_verse;

		$this->end_chapter = $last->end_chapter;
		$this->end_verse = $last->end_verse;

	
	}

	public function getStartChapter() {
		return $this->start_chapter;
	}

	public function getStartVerse() {
		return $this->start_verse;
	}

	public function getEndChapter() {
		return $this->end_chapter;
	}

	public function getEndVerse() {
		return $this->end_verse;
	}

	public function getCount() {
		return count($this->headings);
	}

	public function getHeadings() {
		return $this->headings;
	}
	
}