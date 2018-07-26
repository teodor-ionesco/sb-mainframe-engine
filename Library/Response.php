<?php

namespace Library;

class Response
{
	private static $DATA = [
		"success" => null,
		"note" => null,
		"data" => [
			"cbchl" => null,
			"reply" => null,
			"code" => null,
		],
	];

	/*
	*
	* 
	*
	*/
	public static function read($type = 'array')
	{
		return ($type === 'array') ? self::$DATA : json_encode(self::$DATA);
	}

	/*
	*
	* 
	*
	*/
	public static function update($data)
	{
		if(is_array($data) && !empty($data))
		{
			foreach($data as $key => $value)
			{
				self::$DATA[$key] = $value;
			}

			return;
		}

		throw new Exception("Please input a valid array data.");
	}
	
	/*
	*
	* 
	*
	*/
	public static function send($read = true, $update = true)
	{
		header("Content-Type: application/json");

		if($read === true)
		{
			print_r(json_encode(self::$DATA));
		}
		else
		{
			if($update === true)
			{
				self::update($read);

				print_r(json_encode(self::$DATA));
			}
			else
			{
				print_r(json_encode($read));
			}
		}
	}
}