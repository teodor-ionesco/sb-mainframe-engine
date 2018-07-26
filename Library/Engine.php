<?php

namespace Library;

use Exception;
use Library\Bridge;
use Library\Request;
use Library\Entities\Match;
use Library\Entities\Answer;
use Library\Entities\Question;
use Library\Entities\Code;
use Library\Entities\Challenge;

class Engine
{
	private $string;
	private $match;
	private $answer;
	private $question;
	private $challenge;
	private $code;

	/*
	*
	*
	*/
	public function __construct()
	{
		if(!Request::is_checked())
		{
			throw new Exception("Request mismatch.");
		}

		$this -> string = Bridge::read('public')['request']['string'];
	}

	/*
	*
	*
	*/
	public function ___execute($cbchl = null)
	{
		if($cbchl === null)
		{
			if($this -> match((new Match) -> read('all')))
			{
				$___cborder = $this -> ___cborder();

				Bridge::update(($___cborder !== false) ? $this -> ___cbexec($___cborder) : [
					"success" => 0,
					"note" => "___cborder() failed"
				], 'public');
			}
			else
			{
				Bridge::update(["response" => ["reply" => "Sorry, I did not get that.."]], 'public');
			}
		}
		else if(is_numeric($cbchl))
		{
			if($this -> challenge((new Challenge) -> read('all')))
			{
				$___cborder = $this -> ___cborder();

				Bridge::update(($___cborder !== false) ? $this -> ___cbexec($___cborder) : [
					"success" => 0,
					"note" => "___cborder() failed"
				], 'public');
			}
			else
			{
				Bridge::update([
					"response" => [
						"reply" => "Sorry, I did not get that..",
						"cbchl" => Bridge::read()["cb"]["challenge"],
					]
				], 'public');
			}
		}
		else
		{
			Bridge::update(["response" => ["reply" => "Sorry, I did not get that.."]], 'public');
		}
	}

	/*
	*
	*
	*/
	protected function match($data)
	{
		foreach($data as $key => $vector)
		{
			if(preg_match("/$vector[match]/", $this -> string) === 1)
			{
				$this -> ___cbregister($vector);

				return true;
			}
		}

		return false;
	}

	/*
	*
	*
	*/
	protected function challenge($data)
	{
		foreach($data as $key => $vector)
		{
			$challenge 	= explode("#", $vector["challenge"]);
			$answer 	= explode("#", $vector["cb_answer_id"]);
			$question 	= explode("#", $vector["cb_question_id"]);
			$code 		= explode("#", $vector["cb_code_id"]);

			if(count($challenge) !== count($answer)	||
				count($challenge) !== count($question) ||
				count($challenge) !== count($code))
			{
				return false;
			}

			foreach($challenge as $k => $v)
			{
				if(preg_match("/$v/", $this -> string) === 1)
				{
					$this -> ___cbregister([
						"match" => null,
						"cb_answer_id" => $answer[$k],
						"cb_question_id" => $question[$k],
						"cb_code_id" => $question[$k],
						"cb_challenge_id" => $question[$k],
					]);

					return true;
				}
			}
		}

		return false;
	}

	/*
	*
	*
	*/
	private function ___cbregister($data)
	{
		!empty($data["match"]) 			? 	$this -> match = (int)($data["match"]) 				: null;
		!empty($data["cb_answer_id"]) 	? 	$this -> answer = (int)($data["cb_answer_id"]) 		: null;
		!empty($data["cb_question_id"]) ? 	$this -> question = (int)($data["cb_question_id"]) : null;
		!empty($data["cb_code_id"]) 	? 	$this -> code = (int)($data["cb_code_id"]) 			: null;
		!empty($data["cb_challenge_id"]) ? 	$this -> challenge = (int)($data["cb_challenge_id"]) : null;
	}

	/*
	*
	*
	*/
	private function ___cborder()
	{
		if((int)($this -> answer) !== 0)
			return "answer";

		if((int)($this -> question) !== 0)
			return "question";

		if((int)($this -> code) !== 0)
			return "code";

		return false; 
	}
	
	/*
	*
	*
	*/
	private function ___cbexec($input)
	{
		switch($input)
		{
			case "answer":
			{
				return [
					"response"=> [
						"reply" => (new Answer) -> read('id:'. $this -> answer)["answer"],
					],
				];
			}

			case "question":
			{
				$tmp = (new Question) -> read('id:'. $this -> question);

				return [
					"response"=> [
						"cbchl" => $tmp["cb_challenge_id"],
						"reply" => $tmp["question"],
					],
				];						
			}

			// Causes security issues. Feature ruled out for now.
			//
			/*case "code":
			{
				Bridge::update(["cb" => ["code" => $this -> code]], 'private');

				return [
					"response"=> [
						"code" => (new Code) -> read('id:'. $this -> code)["id"],
					],
				];
			}*/

			default:
			{
				return [
					"success" => 0,
					"note"	=> "___cbexec() failed",
				];
			}
		}
	}
}