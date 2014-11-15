<?php

class PlanController extends BaseController {


	public function __construct() {		

	}

	public function createPlan() {
		$plan = new Plan();
		$plan->createPlan();
	}

	

}
