<?php

namespace Library;

use Exception;
use Library\Request;
use Library\Response;
use Library\Entities\Match;

class Engine
{
	private $string;
	private $match;
	private $answer;
	private $question;
	private $challenge;
	private $code;

	public function __construct()
	{
		if(!Request::is_data())
		{
			throw new Exception("Request mismatch.");
		}

		$this -> string = $_POST["string"];
	}

	public function execute()
	{
		if($this -> match((new Match) -> read('all')))
		{
			
		}
		else
		{
			die( "Sorry, I did not get that..");
		}
	}

	private function match($data)
	{
		foreach($data as $key => $vector)
		{
			if(preg_match("/$vector[match]/", $_POST["string"]) === 1)
			{
				$this -> match = $vector["match"];
				$this -> answer = $vector["cb_answer_id"];
				$this -> question = $vector["cb_question_id"];
				$this -> code = $vector["cb_code_id"];

				return true;
			}
		}

		return false;
	}
}