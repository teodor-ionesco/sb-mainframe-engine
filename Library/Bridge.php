<?php

namespace Library;

use Exception;

class Bridge
{
	private static $PRIVATE = [
		"cb" => [
			"id" => null,
			"match" => null,
			"answer" => null,
			"question" => null,
			"challenge" => null,
			"code" => null,
		],
	];

	private static $PUBLIC = [
		"success" => null,
		"note" => null,

		"request" => [
			'cbhid' => null,
			"cbchl" => null,
			"string" => null,
		],

		"response" => [
			"cbchl" => null,
			"reply" => null,
		],
	];

	/*
	********************************************************
	********************************************************
	********************************************************
	*/
	public static function read($target = "private")
	{
		switch($target)
		{
			case "private":
			{
				return self::$PRIVATE;
			}

			case "public":
			{
				return self::$PUBLIC;
			}

			case "all":
			{
				return [
					self::$PUBLIC,
					self::$PRIVATE,
				];
			}
		}

		throw new Exception("Please input a valid target: 'private' or 'public' or 'all'");
	}

	/*
	********************************************************
	********************************************************
	********************************************************
	*/
	public static function update($data, $target = "private")
	{
		if(is_array($data) && !empty($data))
		{
			foreach($data as $key => $value)
			{
				if(!is_array($value))
				{
					($target === "private") ? self::$PRIVATE[$key] = $value : self::$PUBLIC[$key] = $value;
				}
				else
				{
					foreach($value as $k => $v)
					{
						($target === "private") ? self::$PRIVATE[$key][$k] = $v : self::$PUBLIC[$key][$k] = $v;
					}
				}
			}

			return;
		}

		throw new Exception("Please input a valid array data.");
	}

	/*
	********************************************************
	********************************************************
	********************************************************
	*/
	public static function send($read = true, $update = true)
	{
		header("Content-Type: application/json");

		if($read === true)
		{
			die(json_encode(self :: read("public")));
		}
		else
		{
			if($update === true)
			{
				self :: update($read, 'public');

				die(json_encode(self :: read("public")));
			}
			else
			{
				die(json_encode($read));
			}
		}
	}
}