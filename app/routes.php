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

	/*
		$versions = $api->getVersions();
		//echo "<pre>"; var_dump($versions); echo "</pre>";
		foreach ($versions->response->versions as $version){
			echo $version->id; echo '|'; echo $version->name; echo '<br>';
		}
	*/

	$books = $api->getBooks('eng-GNBDC');
	echo "<pre>"; var_dump($books); echo "</pre>";
	return;

	$passage = $api->getPassage();
	echo "<pre>"; var_dump($passage); echo "</pre>";
	

});

Route::get('/data/books/', 'DataController@getBooks');
Route::get('/data/chapters/', 'DataController@getChapters');
