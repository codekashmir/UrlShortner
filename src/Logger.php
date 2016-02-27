<?php
namespace CodeKashmir\UrlShortner;

class Logger 
{
	const LOG_FILEPATH = '/log.txt';
	public static function log($message)
	{
		$fh = @fopen(self::LOG_FILEPATH, 'a+');
		if($fh)
		{
			fwrite($fh, Date$message);
			fclose($fh);
		}
	}	
}