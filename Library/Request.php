<?php

namespace Library;

use Exception;
use Library\Response;
use Library\Entities\Chatbot;

class Request
{
	private $Chatbot;

	public function __construct()
	{
		$this -> Chatbot = new Chatbot;
	}

	/*
	*
	* 
	*
	*/
	public function check()
	{
		if(isset($_GET["cbhid"]) && !empty($_GET["cbhid"]))
		{
			if($this -> Chatbot -> read('cbhid:'. $_GET["cbhid"]) === false)
			{
				Response::update([
					"success" => 0,
					"note" => "Invalid CBHID"
				]);

				return Response::read();
			}
			
		}

		if(!isset($_POST["string"]) || empty($_POST["string"]))
		{
			Response::update([
				"success" => 0,
				"note" => "No string supplied."
			]);

			return Response::read();
		}
		
		Response::update([
			"success" => 1,
			"note" => "",
			"data" => [
				"cbid" => $this -> Chatbot :: $State["id"],
			],
		]);

		return Response::read();
	}
	
	/*
	*
	* 
	*
	*/
	public static function is_data()
	{
		if(!empty(Response::read()["data"]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}