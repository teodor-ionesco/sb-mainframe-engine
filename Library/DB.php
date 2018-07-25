<?php

namespace Library;

use PDO;
use PDOException;

class DB
{
	private static $c;

	public static function init()
	{
		if(self :: $c == null)
		{
			try
			{
				self :: $c = new PDO("mysql:host=127.0.0.1;dbname=sb_db_bots",
									"root",
									"root",
									[
										PDO::ATTR_PERSISTENT,
									]);
			}
			catch(PDOException $e)
			{
				//echo $e;
				die("Could not connect to database. Please contact the Webmaster.");
			}
		}

		return self :: $c;
	}
}