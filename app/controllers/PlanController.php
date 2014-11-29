<?php

class PlanController extends BaseController {


	public function __construct() {		

	}

	public function createPlan() {
		$plan = new Plan();
		$plan->createPlan();
	}

	public function getPlan() {

		$num_days = Input::get('num_days', 365);
		$version = Input::get('version', 'eng-GNBDC');

		$type = Input::get('version', 'sequential');
		$books = Input::get('books', null);

		$plan = new Plan($num_days,$version,$type,$books);
		$plan->createPlan();
		return $plan;
	}

	public function displayPlan() {
		$plan = new Plan(90, 'eng-GNBDC', 'sequential', array('Matt','Mark','Luke','John'));
		$plan->displayPlan();
	}

	public function getVersions() {
		return $versions = Version::lists('name','abbreviation');
	}

	public function getBooks() {
		return $books = Book::where('version',Input::get('version', 'eng-GNBDC'))
			->lists('name','abbreviation');
	}
	

}
