<?php

class Day  {


	public $start_chapter;
	public $start_verse;

	public $end_chapter;
	public $end_verse;

	public $start_ot_chapter;
	public $start_ot_verse;

	public $end_ot_chapter;
	public $end_ot_verse;

	public $start_nt_chapter;
	public $start_nt_verse;

	public $end_nt_chapter;
	public $end_nt_verse;

	public $type;

	public $headings;
	public $ot_headings;
	public $nt_headings;

	public function __construct($headings) {

		$this->headings = $headings;

		foreach ($headings as $heading) {
			$ot = 0;
			$nt = 0;
			if ($heading->testmanet == 'OT' || $heading->testament == 'DEUT') {
				$ot = 1;
			}
			if ($heading->testmanet == 'NT') {
				$nt = 1;
			}

		}


		if ($ot==1 && $nt==1) {
			$this->type = 'both';
		} else if ($nt==1) {
			$this->type = 'nt';
		} else {
			$this->type = 'ot';
		}

		if (count($headings) > 1) {
			$first = array_shift($headings);
			$last = array_pop($headings);
		} else {
			$first = $headings[0];
			$last = $headings[0];
		}
	
		$this->start_chapter = $first->start_chapter;
		$this->start_verse = $first->start_verse;

		$this->end_chapter = $last->end_chapter;
		$this->end_verse = $last->end_verse;

		$this->type = $first->testament;

		if ($this->type=='NT') {
			$this->start_nt_chapter = $first->start_chapter;
			$this->start_nt_verse = $first->start_verse;
			$this->start_ot_chapter = null;
			$this->start_ot_verse = null;
		} else {
			$this->start_ot_chapter = $first->start_chapter;
			$this->start_ot_verse = $first->start_verse;
			$this->start_nt_chapter = null;
			$this->start_nt_verse = null;
		}

	
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

	public function mergeInTestament($headings) {

		
		$first = array_shift($headings);
		$last = array_pop($headings);

		if ($first->book==$this->type) {
			return;
		}
	
		$this->headings = array_merge($this->headings,$headings);

		$this->start_chapter = $first->start_chapter;
		$this->start_verse = $first->start_verse;

		$this->end_chapter = $last->end_chapter;
		$this->end_verse = $last->end_verse;

		$this->type = $first->testament;

		if ($this->type=='NT') {
			$this->start_nt_chapter = $first->start_chapter;
			$this->start_nt_verse = $first->start_verse;
			$this->start_ot_chapter = null;
			$this->start_ot_verse = null;
		} else {
			$this->start_ot_chapter = $first->start_chapter;
			$this->start_ot_verse = $first->start_verse;
			$this->start_nt_chapter = null;
			$this->start_nt_verse = null;
		}


	}
	

}