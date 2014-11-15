<?php

class Day  {


	protected $start_chapter;
	protected $start_verse;

	protected $end_chapter;
	protected $end_verse;

	protected $headings;

	public function __construct($headings) {

		$this->headings = $headings;
	
		if (!isset($headings[0])) {
			pp($headings);
		}
		$first = $headings[0];




	
	}

	public function getStartChapter() {
		return $this->start_chapter;
	}

	public function getStartVerse() {
		return $this->start_chapter;
	}

	public function getEndChapter() {
		return $this->start_chapter;
	}

	public function getEndVerse() {
		return $this->start_chapter;
	}
	
}