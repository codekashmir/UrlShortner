<?php

namespace CodeKashmir\UrlShortner;

class Logger 
{
	const LOG_FILEPATH = '../log.txt';
	public static function log($message)
	{
		$date = new \DateTime();
		$dateString = $date->format('Y-m-d H:i:s');
		$fh = @fopen(self::LOG_FILEPATH, 'a+');
		if($fh)
		{
			fwrite($fh, $dateString.':'.$message.PHP_EOL);
			fclose($fh);
		}
	}	
}