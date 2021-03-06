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
	public  $dbh;

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
			$this->dbh = new \PDO($dbDriver.':host='.$dbHost.';port='.$dbPort.';dbname='.$dbName,
							$dbUser,
							$dbPass,
							$pdoOptions);
			//catch for exceptions
			$this->dbh->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
			$q = 	'CREATE TABLE IF NOT EXISTS `url`(
					`id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
					`long_url` VARCHAR(255),
					`short_url` VARCHAR(255),
					`short_code` VARCHAR(255),
					`clicks` BIGINT UNSIGNED DEFAULT 0,
					`created_date` DATETIME,
					`updated_date` DATETIME,
					PRIMARY KEY (`id`))';
			//create table if it doesn't exist
			if($this->dbh->exec($q) !== 0) {
				Logger::log("Unable to create table url");
			}
		} catch(\PDOException $ex) { 
			Logger::log("Exception thrown: "+$ex->getMessage());
		}
	}	
}