<?php

class CSVHandler 
{
	/**
	 * Convert CSV file to array.
	 *
	 * @param resource $filepath temporary path to file.
	 *
	 * @return array $rows array with proccessed data.
	 */
	public static function csv_to_array($filepath)
	{
		$rows = array();
		foreach (file($filepath, FILE_IGNORE_NEW_LINES) as $line) {
			if($line){
				$rows[] =  str_getcsv($line);
			}
		}
		return $rows;
	}
}