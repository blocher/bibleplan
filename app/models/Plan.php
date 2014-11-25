<?php

class Plan  {


	protected $num_days;
	protected $version;
	protected $days;
	protected $type;
	protected $books;

	public function __construct($num_days=365, $version='eng-GNBDC', $type='concurrent', $books=null) {

		$this->num_days = $num_days;
		$this->version = $version;
		$this->type = $type;
		$this->books = $books;
	
	}

	protected function createYear($testament=null) {


		

	}

	public function createPlan() {

		$headings = Heading::
			leftJoin('books', function($join) 
                {
                    $join->on('headings.book', '=',  'books.abbreviation');
                    $join->on('headings.version','=', 'books.version');
                })
			->where('headings.version',$this->version)
			->select('headings.*','books.testament','books.order')
			->orderBy('books.order','ASC')
			->orderBy('headings.start_chapter','ASC')
			->orderBy('headings.start_verse','ASC');
		$books = $this->books;
		if ($books!=null && is_array($books)) {
			//$books = "'" . implode("', '", $books) . "'";
			$headings->whereIn('books.abbreviation',$books);
		}

		if ($this->type=='concurrent') {
			$ot_headings = clone $headings;
			$nt_headings = clone $headings;

			$ot_headings = $ot_headings->whereIn('books.testament',array('OT','DEUT'))->get();

			$total = count($ot_headings);
			$ot_per_day = floor($total/$this->num_days);
			$ot_extra = $total % $this->num_days; 

			
			$nt_headings = $nt_headings->where('books.testament','NT')->get();
			$total = count($nt_headings);
			$nt_per_day = floor($total/$this->num_days);
			$nt_extra = $total % $this->num_days;
			

		} else {

			$headings = $headings->get();
			$total = count($headings);
			$per_day = floor($total/$this->num_days);
			$extra = $total % $this->num_days; 

		}
		if ($total<$this->num_days) {
			$this->num_days = $total;
		}
		$days = [];
		$num_days = $this->num_days;
		$headings_array = (array)$headings;
		for ($i=0; $i<$num_days; $i++) {
			$day = [];
			if ($this->type=='concurrent') {

				$max = $i < $ot_extra ? $ot_per_day + 1 : $ot_per_day;
				for ($j=0; $j<$max; $j++) {
					$heading = $ot_headings->shift();
					if ($heading===null) {
						break;
					}
					$day[] = $heading;
				}

				$max = $i < $nt_extra ? $nt_per_day + 1 : $nt_per_day;
				for ($j=0; $j<$max; $j++) {
					$heading = $nt_headings->shift();
					if ($heading===null) {
						break;
					}
					$day[] = $heading;
				}

				if (count($day)>0) {
					$days[] = new Day($day);
				}

			} else {
				$max = $i < $extra ? $per_day + 1 : $per_day;
				for ($j=0; $j<$max; $j++) {
					$heading = $headings->shift();
					if ($heading===null) {
						break;
					}
					$day[] = $heading;
				}

				if (count($day)>0) {
					$days[] = new Day($day);
				}
			}
		}

		$total = 0;
		foreach ($days as $day) {
			$total += $day->getCount();
		}
		$this->days = $days;
		return $days;
		

	}

	public function displayPlan() {

		if (!isset($this->days) || empty($this->days)) {
			$this->createPlan();
		}

		foreach ($this->days as $day) {
			echo '<strong>New Day</strong><br>';
			foreach ($day->getHeadings() as $heading) {
				echo $heading->book.' '.$heading->start_chapter.':'.$heading->start_verse.' to '.$heading->end_chapter.':'.$heading->end_verse.' '.$heading->heading_text.'<br>';
			}


		}

	}
	
}