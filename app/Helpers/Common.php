<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Common {
	public static function getRepeatString( $i, $t = '_' )
    {
    	$str = $t;
        if( !empty((int)$i) ) {
        	for( $j=0; $j <= $i; $j++ ){
        		$str .= $t;
        	}
        }
        return $str;
    }

    public static function getsTimeAgo( $time )
    {
        if( !empty($time) ) {
            $start_date = new \DateTime($time);
            $since_start = $start_date->diff(new \DateTime(date('Y-m-d H:m:s')));
            return $since_start->days;
        }
        return 0;
    }

    public static function getsAgoUpdate( $time )
    {
        if( !empty($time) && !empty($time['updated_at']) ) {
            $start_date = new \DateTime($time['updated_at']);
            $since_start = $start_date->diff(new \DateTime(date('Y-m-d H:m:s')));
            return $since_start->days;
        }
        return 0;
    }

    public static function getColorRanger( $value )
    {
        $color = '';
        if( $value >= 0 & $value < 1000 ) {
            $color = 'ranger-01';
        } else if( $value >= 1000 & $value < 10000 ) {
            $color = 'ranger-02';
        } else  if ( $value >= 10000 & $value < 100000 ) {
            $color = 'ranger-03';
        }
        return $color;
    }

    public static function formatDate( $value, $type = 'Ymd' )
    {
        $min = new \DateTime('2018-05-01 00:00');
        $datetime = new \DateTime($value);
        //$date = $datetime->format('Y-m-d');
        $date = max($min, $datetime)->format('Y-m-d');
        return $date;
    }

    public static function parseArray( $value, $plic = ',' ){
        if( !is_array($value) ) {
            $value = explode($plic, $value);
        }
        return $value;
    }

    public static function getRemoveChildByValue( $list , $val )
    {
        if( !empty($list) && !empty($val) ) {
            $kval = array_search($val, $list);
            if( isset($list[$kval]) ) {
                unset($list[$kval]);
            }
        }
        return $list;
    }

    public static function gRString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function getUIString( $len = 20 ){
        return max(0, date('Y')-2010).Common::gRString($len).date('mdHms');
    }

    public static function truncateString( $tr, $len = 200 ){
        if ( !empty($tr) ) {
            return Str::words($tr, $len);
        }
        return '';
    }

    public static function getPrefixLang(){
        if ( !empty(\Session::get('lang')) ) {
            return '/' .\Session::get('lang');
        }
        return '';
    }

    public static function hasPermission( $module, $controller, $action ){
        if ( empty(app()->make('request')->session()->get('auth'))
                || empty($module) || empty($controller) || empty($action) ) {
            return FALSE;
        }
        $type = app()->make('request')->session()->get('auth')['type'];
        $is_admin = app()->make('request')->session()->get('auth')['is_admin'];
        $permissions = app()->make('request')->session()->get('auth')['permissions'];
        if ( ($type == 'admin' && !empty($is_admin)) 
                || (!empty($permissions[strtolower($module)]) && !empty($permissions[strtolower($module)][strtolower($controller)]) && in_array(strtolower($action), $permissions[strtolower($module)][strtolower($controller)])) ) {
            return TRUE;
        }
        return FALSE;
    }
}
