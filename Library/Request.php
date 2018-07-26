<?php

namespace Library;

use Exception;
use Library\Bridge;
use Library\Entities\Chatbot;

class Request
{
	private $Chatbot;

	public function __construct()
	{
		$this -> Chatbot = new Chatbot;
	}

	/*
	********************************************************
	********************************************************
	********************************************************
	*/
	public function check()
	{
		if(isset($_POST["cbhid"]) && !empty($_POST["cbhid"]))
		{
			if($this -> Chatbot -> read('cbhid:'. $_POST["cbhid"]) === false)
			{
				Bridge::update([
					"success" => 0,
					"note" => "Invalid CBHID"
				], 'public');

				return false;
			}
		}
		else
		{
			Bridge::update([
				"success" => 0,
				"note" => "CBHID not supplied"
			], 'public');

			return false;
		}

		if(!isset($_POST["string"]) || empty((string)($_POST["string"])))
		{
			Bridge::update([
				"success" => 0,
				"note" => "No string supplied."
			], 'public');

			return false;
		}

		if(isset($_POST["cbchl"]) && !empty((string)($_POST["cbchl"])))
		{
			Bridge::update(['cb' => ['challenge' => $_POST["cbchl"],],], 'private');
			Bridge::update(['request' => ['cbchl' => $_POST["cbchl"],],], 'public');
		}

		Bridge::update([
			"cb" => [
				"id" => $this -> Chatbot :: $State["id"],
			],
		], 'private');

		Bridge::update([
			"success" => 1,
			"request" => [
				'cbhid' => $_POST["cbhid"],
				'string' => $_POST["string"],
			],
		], 'public');

		return true;
	}
	
	/*
	********************************************************
	********************************************************
	********************************************************
	*/
	public static function is_checked()
	{
		if(Bridge::read('private')['cb']['id'] !== null)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}