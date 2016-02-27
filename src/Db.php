<?php
namespace CodeKashmir\UrlShortner;
use Logger;
class Db 
{
	const DB_NAME = '';
	const DB_USER = '';
	const DB_PASSWORD = '';
	const DB_DRIVER = '';
	const DB_HOST = '';
	const DB_PORT = '';
	function __construct()
	{
		try
		{

		}
		catch(Exception $e)
		{
			Logger:log("Exception thrown: "+$e->getMessage());
		}
	}	
}