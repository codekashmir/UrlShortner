<?php
require_once __DIR__.'/../vendor/autoload.php';

/*
connect to database
 */
$db = new CodeKashmir\UrlShortner\Db();

echo file_get_contents('./home.html');