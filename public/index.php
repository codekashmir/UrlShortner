<?php
if(!empty($_POST)){
	require_once __DIR__.'/../vendor/autoload.php';
	/*
	connect to database
	 */
	$db = new CodeKashmir\UrlShortner\Db();
	/*
	 instantiate Url shortener service
	*/
	$urlShortner = new CodeKashmir\UrlShortner\UrlShortner();
	/*
		output shortened Url
	*/
	echo $urlShortner->shortn($_POST['siteurl']);
	die();
}

echo file_get_contents('./home.html');