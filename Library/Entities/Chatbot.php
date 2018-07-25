<?php

namespace Library\Entities;

use Exception;
use PDOException;
use Library\DB;

class Chatbot implements Def
{
	public static $State;
	private $DB;

	public function __construct()
	{
		$this -> DB = DB::init();
	}

	public function read($target)
	{
		if($target === 'all')
		{
			self::$State = $this -> DB -> query("
											SELECT * 
											FROM chatbot;
								");
			return self::$State;
		}
		else
		{
			$x = explode(':', $target);

			if(is_array($x) && !empty($x[0]) && !empty($x[1]))
			{
				try
				{
					$ret = $this -> DB -> prepare("
													SELECT *
													FROM chatbot
													WHERE chatbot.$x[0] = :$x[0] ;
										");

					$ret -> execute([":$x[0]" => $x[1]]);
					self::$State = $ret -> fetch();
				}
				catch(PDOException $e)
				{
					die("Database connection issue. Please contact the webmaster.");
				}

				return self::$State;
			}
		}

		throw new Exception("Please input a valid target: 'all' or 'col:val'");
	}
}