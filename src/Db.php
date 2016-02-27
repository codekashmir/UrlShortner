<?php

namespace CodeKashmir\UrlShortner;

use CodeKashmir\UrlShortner\Logger as Logger;

class Db 
{
	/* mysql database config*/
	const DB_NAME 		= 'us_db';
	const DB_USER 		= 'aqib';
	const DB_PASSWORD 	= 'password';
	const DB_DRIVER 	= 'mysql';
	const DB_HOST 		= 'localhost';
	const DB_PORT 		= '3306';

	/*database connection*/
	private $dbh;

	/**
	 * [__construct create a connection to database]
	 */
	public function __construct()
	{
		$dbDriver 	= self::DB_DRIVER;
		$dbName 	= self::DB_NAME;
		$dbPass 	= self::DB_PASSWORD;
		$dbPort 	= self::DB_PORT;
		$dbUser 	= self::DB_USER;
		$dbHost 	= self::DB_HOST;
		try {
			//options for pdo
			$pdoOptions = 	[
							\PDO::ATTR_PERSISTENT => true
							];
			//connect to db					
			$dbh = new \PDO($dbDriver.':host='.$dbHost.';port='.$dbPort.';dbname='.$dbName,
							$dbUser,
							$dbPass,
							$pdoOptions);
			//catch for exceptions
			$dbh->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
		} catch(PDOException $ex) { 
			//log exception
			Logger:log("Exception thrown: "+$e->getMessage());
		}
	}	
}