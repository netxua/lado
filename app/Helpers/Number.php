<?php
/**
 * Created by PhpStorm.
 * User: huyvh
 * Date: 11/2/17
 * Time: 4:04 PM
 */
/**
 * SSP Function Common
 */

namespace App\Helpers;
use Illuminate\Support\Facades\DB;

class Number {
	public static function fomatNumber( $number )
    {
        $decimals = 1;
        $decimalpoint='.';
        $separator=',';
        return number_format($number,$decimals,$decimalpoint,$separator);
    }

    public static function getInt( $string )
    {
        //$string = 'Nrs 89,994,874.0098';
		$number = preg_replace("/[^0-9]/", '', $string);
        return (int)$number;
    }

    public static function getFloat( $string )
    {
        //$string = 'Nrs 89,994,874.0098';
        $number = preg_replace("/[^0-9\.]/", '', $string);
        return (float)$number;
    }
}
