<?php

namespace CodeKashmir\UrlShortner;

use CodeKashmir\UrlShortner\Logger as Logger;

class UrlShortner
{	
	/**
	 * [$dbh handle to database]
	 * @var [context]
	 */
	private $dbh;

	private $idOffset = 1000;

	/**
	 * [__construct]
	 * @param [type] $url [url to be shortened]
	 * @param [type] $dbh [handle to database]
	 */
	public function __construct($dbh)
	{
		$this->dbh = $dbh;
	}

	/**
	 * [shortn method for shotening the url]
	 * @return [array] [response containing shortened url]
	 */
	public function shortn($url)
	{
		$response = [
			'shortnedUrl' => '',
			'error' => false,
			'errorMessage' => ''
		];
		
		if (!$this->validateUrl($url)) {
			$response['error'] = true;
			$response['errorMessage'] = "Invalid Url";
			return json_encode($response);
		}
		
		$url = trim($url);

		if (($id = $this->isUrlExists($url)) !== false) {
			$response['shortnedUrl'] = $this->getShortUrl($id);
			$response['error'] = false;
			return $response;
		}

		$id = $this->insertUrlInDb($url);

		if($id === false) {
			$response['error'] = true;
			$response['errorMessage'] = 'Unable to save url in database';
			return $response;
		}

		$shortUrl = $this->insertShortCodeInDb($id, $this->strToBaseConvert($id+$this->idOffset));
		
		if ($shortUrl === false) {
			$response['error'] = true;
			$response['errorMessage'] = 'Unable to create shortcode';
			return $response;
		}
		
		return $shortUrl;
	}

	/**
	 * [validateUrl]
	 * @param  [string] $url 
	 * @return [boolean]      [true if valid url]
	 */
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

	/**
	 * [isUrlExists return false if url doesn't exist or its id in db]
	 * @param  [string]  $url 
	 * @return boolean or integer      
	 */
	public function isUrlExists($url)
	{
		try {
			$q = 'SELECT * FROM `url` WHERE `long_url` = :long_url';
			$stmt = $this->dbh->prepare($q);
			$stmt->bindParam(':long_url', $url);
			if (!$stmt->execute()) {
				return false;
			} 
			$rset = $stmt->fetch(\PDO::FETCH_ASSOC);
			if (empty($rset)) {
				return false;
			}
		} catch(\PDOException $ex) {
			return $ex->getMessage();
		}
		return $rset['id'];
	}

	/**
	 * [strToBaseConvert convert number to base 36]
	 * @param  [type]  $str      [description]
	 * @param  integer $frombase [description]
	 * @param  integer $tobase   [description]
	 * @return [type]            [description]
	 */
	public function strToBaseConvert($str, $frombase=10, $tobase=36) 
	{
	    $str = trim($str);
	    if (intval($frombase) != 10) {
	        $len = strlen($str);
	        $q = 0;
	        for ($i=0; $i<$len; $i++) {
	            $r = base_convert($str[$i], $frombase, 10);
	            $q = bcadd(bcmul($q, $frombase), $r);
	        }
	    }
	    else $q = $str;

	    if (intval($tobase) != 10) {
	        $s = '';
	        while (bccomp($q, '0', 0) > 0) {
	            $r = intval(bcmod($q, $tobase));
	            $s = base_convert($r, 10, $tobase) . $s;
	            $q = bcdiv($q, $tobase, 0);
	        }
	    }
	    else $s = $q;

	    return $s;
	}

	/**
	 * [insertUrlInDb insert new url in database and get it's primary key]
	 * @param  [string] $url 
	 * @return [boolean or integer]      
	 */
	public function insertUrlInDb($url)
	{
		$q = 'INSERT INTO `url`
			 (`long_url`,`created_date`,`updated_date`)
			 VALUES (:long_url, :created_date, :updated_date)';
		$stmt = $this->dbh->prepare($q);
		$currentDate = new \DateTime();
		$currentDate->setTimeZone(new \DateTimeZone('UTC'));
		$values = [	':long_url'		=> $url,
					':created_date'	=> $currentDate->format('Y-m-d H:i:s'),
					':updated_date' => $currentDate->format('Y-m-d H:i:s')];
		if (!$stmt->execute($values)) {
			return false;
		}
		return $this->dbh->lastInsertId();
	}

	public function insertShortCodeInDb($id, $shortCode)
	{
		$q = 'UPDATE `url` SET `short_url` = :short_url WHERE `id` = :id';
		$stmt = $this->dbh->prepare($q);
		$prefix = $_SERVER['REQUEST_URI'];
		$values = [	':short_url' => $prefix.'/'.$shortCode,
					':id' => $id];
		if (!$stmt->execute($values)) {
			return false;
		}
		return true;
	}



	public function findActualUrl($url)
	{
		
	}
}