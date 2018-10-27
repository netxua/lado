<?php
namespace Backend\Models;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Lang, Cache;

class App extends Eloquent
{
    protected $user = array();
    protected $lang = 'vn';
    protected $language_id = 1;
    protected $connection = 'mongodb';

    public function __construct(){
        if( app()->make('request')->session()->has('auth') ){
            $this->user = app()->make('request')->session()->get('auth');
        }
        if( app()->make('request')->session()->has('lang') ){
            $this->lang = request()->session()->get('lang');
        }
        $this->language_id = 1;
    }
    /**
     * @param array $options
     * @return bool
     */
    public function saveNoUser(array $options = []){

        $check = parent::save($options);
        if($check){
            if (\Config::get('backend_config.log_config')['log_insert'])
            {
                $user_name = "admin";
                if(\Session::has("auth")){
                    $user_name = \Session::get("auth")["user_username"];
                }
                $ip = app()->make('request')->ip();
                write_log_file(
                    "insert_database__{$user_name}",
                    "User: {$user_name}, ip: {$ip}, Table: {$this->table}, Data: " . json_encode($this->getAttributes()),
                    "info"
                );
            }
        }
        return $check;
    }
    
    public function updateNoUser(array $attributes = [], array $options = []){

        $check = parent::update($attributes, $options);
        if($check){
            if (\Config::get('backend_config.log_config')['log_update'])
            {
                $user_name = "admin";
                if(\Session::has("auth")){
                    $user_name = \Session::get("auth")["user_username"];
                }
                $ip = app()->make('request')->ip();
                write_log_file(
                    "update_database__{$user_name}",
                    "User: {$user_name}, ip: {$ip}, Table: {$this->table}, Data: " . json_encode($this->getAttributes()),
                    "info"
                );
            }
        }
        return $check;

    }
    /**
     * @param array $options
     * @return bool
     */
    public function save( array $options = [] ){

        if( empty($this->user_created_id) ){
            $this->user_created_id = app()->make('request')->session()->get('auth')['user_id'];
        }
        $check = parent::save($options);
        if($check){
            if (\Config::get('backend_config.log_config')['log_insert'])
            {
                $user_name = "admin";
                if(\Session::has("auth")){
                    $user_name = \Session::get("auth")["user_username"];
                }
                $ip = app()->make('request')->ip();
                write_log_file(
                    "insert_database__{$user_name}",
                    "User: {$user_name}, ip: {$ip}, Table: {$this->table}, Data: " . json_encode($this->getAttributes()),
                    "info"
                );
            }
        }
        return $check;
    }
    /**
     * @param array $attributes
     * @param array $options
     * @return bool|int
     */
    public function update(array $attributes = [], array $options = []){
        if(empty($this->user_updated_id)){
            $this->user_updated_id = app()->make('request')->session()->get('auth')['user_id'];
        }
        $check = parent::update($attributes, $options);
        if($check){
            if (\Config::get('backend_config.log_config')['log_update'])
            {
                $user_name = "admin";
                if(\Session::has("auth")){
                    $user_name = \Session::get("auth")["user_username"];
                }
                $ip = app()->make('request')->ip();
                write_log_file(
                    "update_database__{$user_name}",
                    "User: {$user_name}, ip: {$ip}, Table: {$this->table}, Data: " . json_encode($this->getAttributes()),
                    "info"
                );
            }
        }
        return $check;

    }

    protected function getModel( $model_name = null )
    {
        $model_focus = $this->model_name;
        if ($model_name) {
            $model_focus = $model_name;
        }
        if ($model_focus) {
            $model_path = '\\Backend\Models\\' . ucfirst($model_focus);
            $model = new $model_path();
            return $model;
        }else{
            return null;
        }
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