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
	public function shortn()
	{
		$response = [
			'shortnedUrl' => '',
			'error' => false,
			'errorMessage' => ''
		];
		if($this->validateUrl($this->url)){
			$response['error'] = true;
			$response['errorMessage'] = "Invalid Url";
			return json_encode($response);
		}

	}

	public function validateUrl($url)
	{
		if(empty($url)){
			return false;
		}
		if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
    		return true;
		} else {
    		return false;
		}
	}
}