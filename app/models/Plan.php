<?php

class Plan  {


	protected $num_days;
	protected $version;
	protected $days;

	public function __construct($num_days=90, $version='eng-GNBDC') {

		$this->num_days = $num_days;
		$this->version = $version;
		
	}

	public function createPlan() {

		$headings = Heading::
			leftJoin('books', function($join) 
                {
                    $join->on('headings.book', '=',  'books.abbreviation');
                    $join->on('headings.version','=', 'books.version');
                })
			->where('headings.version',$this->version)
			->select('headings.*')
			->orderBy('books.order','ASC')
			->orderBy('headings.start_chapter','ASC')
			->orderBy('headings.start_verse','ASC')
			
			->get();

	    $total = count($headings);
		$per_day = floor($total/$this->num_days);
		$extra = $total % $this->num_days; 

		$num_days = $this->num_days;
		
		$days = [];

		$headings_array = (array)$headings;
		for ($i=0; $i<$num_days; $i++) {
			$day = [];
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

		$total = 0;
		foreach ($days as $day) {
			$total += $day->getCount();
		}

		$this->days = $days;
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