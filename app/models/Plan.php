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

		$per_day = ceil($total/$this->num_days);

		$num_days = $this->num_days;
		
		$days = [];

		$headings_array = (array)$headings;
		for ($i=0; $i<$num_days; $i++) {
			$day = [];
			for ($j=0; $j<$per_day; $j++) {
				$heading = $headings->shift();
				if ($heading===null) {
					break;
				}
				$day[] = $heading;
			}
			foreach ($day as $heading) {
					echo  $heading->version." ".$heading->book." ".$heading->start_chapter.':'.$heading->start_verse.' to '.$heading->end_chapter.':'.$heading->end_verse.'<br>';;
			} 
			$days[] = new Day($day);
	
		}
		$this->days = $days;


	}
	
}