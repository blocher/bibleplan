<?php

class PlanController extends BaseController {


	public function __construct() {		

	}

	public function createPlan() {
		$plan = new Plan();
		$plan->createPlan();
	}

	public function displayPlan() {
		$plan = new Plan(90, 'eng-GNBDC', 'sequential', array('Matt','Mark','Luke','John'));
		$plan->displayPlan();
	}

	

}
