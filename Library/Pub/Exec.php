<?php

namespace Library\Pub;

use ParseError;

class Exec extends ParseError
{
	public function __construct()
	{}

	public function ___exec($code)
	{
		$ret = null;

		try
		{
			ob_start();
				eval($code);
				$ret = ob_get_contents();
			ob_end_clean();
		}
		catch(ParseError $e)
		{
			$ret = 'Line '. $e -> line .': '. $e -> message;
		}

		return $ret;
	}
}