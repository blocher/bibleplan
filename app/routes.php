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

	echo 'Welcome to Bible Planner';

	die();
	

});

Route::get('/import/books/', 'ImportController@importBooks');
Route::get('/import/headings/', 'ImportController@importHeadings');


Route::get('/plan/create', 'PlanController@createPlan');
