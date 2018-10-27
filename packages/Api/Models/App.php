<?php
namespace Api\Models;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder as BaseBuilder;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Cache;

class App extends Eloquent
{
    protected $user = array();
    protected $lang = 'vn';
    protected $language_id = 1;
    protected $connection = 'mongodb';

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
    }
    
    protected function getModel( $model_name = null )
    {
        $modelPath = '\\Api\Models\\' . ucfirst($model_name);
        $model = new $modelPath();
        return $model;
    }

    protected function hasPaging( $params ) {
        if( isset($params['page']) && !empty($params['limit']) ){
            return TRUE;
        }
        return FALSE;
    }

    protected function getOffsetPaging( $page, $limit ) {
        $ipage = max(($page - 1), 0) * $limit;
        return $ipage;
    }

    public function getUser()
    {
        if( !empty($this->user) ) {
            return $this->user;
        }
        return array();
    }

    public function getLang()
    {
        if( !empty($this->lang) ) {
            return $this->lang;
        }
        return 'vn';
    }

    public function getLanguageId()
    {
        if( !empty($this->language_id) ) {
            return $this->language_id;
        }
        return 1;
    }

    protected function toAlias($txt, $str = '-') {
        if ($txt == '')
            return '';
        $marked = array ("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă","ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề","ế", "ệ", "ể", "ễ", "ế",             "ì", "í", "ị", "ỉ", "ĩ","ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ","ờ", "ớ", "ợ", "ở", "ỡ","ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ","ỳ", "ý", "ỵ", "ỷ", "ỹ","đ","À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă","Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ","È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ","Ì", "Í", "Ị", "Ỉ", "Ĩ","Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ","Ờ", "Ớ", "Ợ", "Ở", "Ỡ","Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ","Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ","Đ", " ", "&", "?", "/", ".", ",", "$", ":", "(", ")", "'", ";", "+", "–", "’" );
    
        $unmarked = array ("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "e","e", "e", "e", "e", "e", "i", "i", "i", "i", "i","o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o","o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",  "y", "y", "y", "y", "y", "d", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "D", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-" );
    
        $tmp3 = (str_replace ( $marked, $unmarked, $txt ));
        $tmp3 = rtrim ( $tmp3, $str );
        $tmp3 = preg_replace ( array ('/\s+/', '/[^A-Za-z0-9\-]/' ), array ($str, '' ), $tmp3 );
        $tmp3 = preg_replace ( '/-+/', $str, $tmp3 );
        $tmp3 = strtolower ( $tmp3 );
        return $tmp3;
    }

    protected function parseArray( $value, $plic = ',' ){
        if( !is_array($value) ) {
            $value = explode($plic, $value);
        }
        return $value;
    }
}