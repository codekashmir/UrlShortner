<?php

namespace CodeKashmir\UrlShortner;

use CodeKashmir\UrlShortner\Logger as Logger;

class UrlShortner
{
	/**
	 * [$url url to be shortened]
	 * @var [string]
	 */
	private $url;
	
	/**
	 * [$dbh handle to database]
	 * @var [context]
	 */
	private $dbh;

	/**
	 * [__construct]
	 * @param [type] $url [url to be shortened]
	 * @param [type] $dbh [handle to database]
	 */
	public function __construct($url, $dbh)
	{
		$this->url = $url;
		$this->dbh = $dbh;
	}

	/**
	 * [shortn method for shotening the url]
	 * @return [array] [response containing shortened url]
	 */
	public function shortn(){
		$response = [
			'shortnedUrl' => '',
			'error' => false,
			'errorMessage' => ''
		];
		
	}
}