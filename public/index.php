<?php

require_once('../autoload.php');

use Library\Request;
use Library\Response;

if((new Request) -> check()["success"] === 0)
{
	Response::send();
	exit();
}

use Library\Engine;

(new Engine) -> execute();