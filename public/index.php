<?php
print_r($_GET);
if(!empty($_POST)){
	require_once __DIR__.'/../vendor/autoload.php';
	/*
	connect to database
	 */
	$db = new CodeKashmir\UrlShortner\Db();
	/*
	 instantiate Url shortener service
	*/
	$urlShortner = new CodeKashmir\UrlShortner\UrlShortner($_POST['siteurl'], $db->dbh);
	/*
		output shortened Url
	*/
	echo $urlShortner->shortn();
	die();
}

echo file_get_contents('./home.html');