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

class Currency {
	public static function fomatCurrency( $number )
    {
        $str ='';
        $decimals = 1;
        $decimalpoint='.';
        $separator=',';
        $symbol = 'VND';
        switch ( $symbol ) {
            case 'VND':
                $str = number_format($number,$decimals,$decimalpoint,$separator). ' đ';
                break;
            case 'CNY':
                $str = number_format($number,$decimals,$decimalpoint,$separator). ' yuan';
                break;
            case 'USD':
                $str = '$'.number_format($number,$decimals,$decimalpoint,$separator);
                break;
            case 'EUR':
                $str = '€'.number_format($number,$decimals,$decimalpoint,$separator);
                break;
            case 'GBP':
                $str = '£'.number_format($number,$decimals,$decimalpoint,$separator);
                break;
            case 'JPY':
                $str = '¥'.number_format($number,$decimals,$decimalpoint,$separator);
                break;
            case 'SGD':
                $str = 'S$'.number_format($number,$decimals,$decimalpoint,$separator);
                break;
            case 'KRW':
                $str = '₩'.number_format($number,$decimals,$decimalpoint,$separator);
                break;
            case 'THB':
                $str = '฿'.number_format($number,$decimals,$decimalpoint,$separator);
                break;
            case 'AUD':
                $str = '$'.number_format($number,$decimals,$decimalpoint,$separator);
                break;
            default:
                $str = '$'.number_format($number,$decimals,$decimalpoint,$separator);
                break;
        }
        return $str;
    }
}
