<?php

require_once('../autoload.php');

use Library\Bridge;
use Library\Request;
use Library\Engine;
use Library\Pub\Exec;
use Library\Entities\Code;

if((new Request) -> check() === false)
{
	Bridge::send();
	exit();
}

switch(Bridge::read()['cb']['challenge'])
{
	case (null):
	{
		(new Engine) -> ___execute();
		break;
	}

	default:
	{
		(new Engine) -> ___execute(Bridge::read()['cb']['challenge']);
		break;
	}
}

if(Bridge::read()['cb']['code'] !== null)
{
	Bridge::update(["response" => 
		["reply" => (new Exec()) -> ___exec((new Code) -> read('id:'. Bridge::read()['cb']['code'])["code"])]
	], 'public');
}

Bridge::send();