<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	
	$api = new BiblesApi();
	$plan = API::with(['num_days'=>Input::get('num_days',365),'version'=>Input::get('version','eng-GNBDC')])->get('plan');
	$days = $plan->days;
	$versions = API::get('versions');
	return View::make('home')
		->with('days',$days)
		->with('versions',$versions)
	;

	die();
	

});

Route::get('/import/books/', 'ImportController@importBooks');
Route::get('/import/headings/', 'ImportController@importHeadings');


Route::get('/plan/create', 'PlanController@createPlan');
Route::get('/plan/display', 'PlanController@displayPlan');

Route::api(['version'=>'v1', 'prefix'=>'api'], function() {

	Route::get('plan', 'PlanController@getPlan');
	Route::get('versions', 'PlanController@getVersions');

});