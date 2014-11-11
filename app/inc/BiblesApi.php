<?php

class BiblesApi {

	protected $key = 'EzczKHVNVZoOPeGqtRUpwYJd6rRE81TfaoMnDj7B';

	protected $url = 'https://bibles.org/v2/';

	protected function makeRequest($query_string) {

		$token = $this->key;

		$url = $this->url.$query_string;

		// Set up cURL
		$ch = curl_init();
		// Set the URL
		curl_setopt($ch, CURLOPT_URL, $url);
		// don't verify SSL certificate
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		// Return the contents of the response as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// Follow redirects
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		// Set up authentication
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "$token:X");

		// Do the request
		$response = curl_exec($ch);
		//echo $response;
		curl_close($ch);

		$response = json_decode($response);

		return $response;

	}

	public function getPassage($passage="Genesis 1",$version='eng-KJVA') {
		
		$passage = urlencode($passage);
		$version = urlencode($version);
		
		$query_string = 'passages.js?q[]='.$passage.'&version='.$version;

		return $this->makeRequest($query_string);

	}

	public function getVersions() {

		$query_string = 'versions.js';

		return $this->makeRequest($query_string);
	}

	public function getBooks($version='eng-KJVA') {
		$query_string = 'versions/'.$version.'/books.js?include_chapters=true';
		return $this->makeRequest($query_string);
	}

}

?>