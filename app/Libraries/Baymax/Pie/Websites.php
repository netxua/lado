<?php
namespace Libraries\Baymax\Pie;
use Libraries\Baymax\core;
use Lang, Cache;

class Websites extends core{
	public function remember( $key, $callback, $time = '' ) {
		parent::boot($key, $callback, $time = '');
	}
}
