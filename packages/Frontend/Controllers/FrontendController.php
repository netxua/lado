<?php
namespace Frontend\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use Doctrine\DBAL\Schema\View;
//use Illuminate\Database\Eloquent\Model;
use igaster\laravelTheme\Facades\Theme;
use Illuminate\Routing\Route;
Use Illuminate\Support\Facades\DB;
Use Libraries\Baymax\core AS BCached;
use Lang, Cache;

class FrontendController extends Controller
{
    protected $module_name;
    protected $model_name;
    protected $controller_name;
    protected $action_name;
    protected $referer;
    protected $user = array();
    protected $website = array();
    protected $dataView = array();
    protected $baseUrl = '';
    protected $page = 1;
    protected $pageSize = 20;
    protected $is_pjax = FALSE;
    protected $pjx = 0;
    protected $hasHeader = TRUE;
    protected $hasFooter = TRUE;
    protected $layout = 'default';
    protected $languages = array();
    protected $lang = 'vn';
    protected $langId = 1;

    public function __construct(){
        $this->beforeExecuteRoute();
        if( !empty(app()->make('request')->session()->has('_USER')) ){
            $this->user = app()->make('request')->session()->get('_USER');
        }
        $this->referer = \Request::server('HTTP_REFERER');
        $this->website =  $this->getModel('Website')->getWebsite();print_r($this->website);die();
        if ( empty($this->website) ) {
            die('Not found website');
        }
        Theme::configSet('title', $this->website->erp_name);
        $this->languages =  $this->getModel('Language')->getLanguages();
        if( request()->session()->has('lang') ){
            $this->lang = request()->session()->get('lang');
        }
        if( request()->session()->has('langId') ){
            $this->langId = request()->session()->get('langId');
        }
        \Session::put('lang', $this->lang);
        \Session::put('langId', $this->langId);
        \Session::save();
        view()->share('lang', $this->lang);
        view()->share('langId', $this->langId);
        view()->share('website', $this->website);
        view()->share('_USER', $this->user);
        view()->share('current_controller',$this->controller_name);
        view()->share('current_action',($this->action_name == '') ? 'list' : $this->action_name);
        $this->page = request()->get('page', 1);
        $this->pageSize = request()->get('limit', $this->pageSize);
        $this->pjx = request()->get('pjx', 0);
        $this->is_pjax = request()->header('X-PJAX', FALSE);
        if( !empty($this->is_pjax) ) {
            $this->layout = 'pjax';
            if( !empty($this->pjx) ) {
                $this->layout = 'ajax';
            }
        }
        $urlLang = __DIR__.'/../Locale/'.$this->lang.'/lang.php';
        $_keywords = include $urlLang;
        $this->addDataView('langId', $this->langId);
        $this->addDataView('lang', $this->lang);
        $this->addDataView('website', $this->website);
        $this->addDataView('languages', $this->languages);
        $this->addDataView('page', $this->page);
        $this->addDataView('limit', $this->pageSize);
        $this->addDataView('is_pjax', $this->is_pjax);
        $this->addDataView('layout', $this->layout);
        $this->addDataView('current_user', $this->user);
        $this->addDataView('current_module', $this->module_name);
        $this->addDataView('current_model', $this->model_name);
        $this->addDataView('current_controller', $this->controller_name);
        $this->addDataView('current_action', $this->action_name);
        $this->addDataView('_keywords', $_keywords);
        $this->addDataView('hasHeader', $this->hasHeader);
        $this->addDataView('hasFooter', $this->hasFooter);
    }

    public function beforeExecuteRoute()
    {
        $this->controller_name = app()->make('request')->segment(2);
        $this->action_name = app()->make('request')->segment(3);
    }
    
    public function redirect($url = null){
        return \Redirect::to(\HelperCommon::getPrefixLang().'/'.$url);
    }

    protected function getModel( $model_name = null )
    {
        $model_focus = $this->model_name;
        if ($model_name) {
            $model_focus = $model_name;
        }
        if ($model_focus) {
            $model_path = '\\Frontend\Models\\' . ucfirst($model_focus);
            $model = new $model_path();
            return $model;
        }else{
            return null;
        }
    }

    protected function resJson($data)
    {
        response('')->header('Content-Type', 'JSON');
        response('')->header('Data-Type', 'JSON');
        return response()->json($data);
    }

    public function isLogin( )
    {
        if( !empty($this->user) ) {
            return TRUE;
        }
        return FALSE;
    }

    public function getUser()
    {
        if( !empty($this->user) ) {
            return $this->user;
        }
        return array();
    }

    public function getDataView()
    {
        return $this->dataView;
    }

    public function addDataView( $key, $data )
    {
        if( isset($key) && isset($data) ){
            $this->dataView[$key] = $data;
        }
        return $this->dataView;
    }

    public function buildParamsForUrlFromArray( $params ){
        $url = '';
        foreach ( $params as $key => $value) {
            if( !empty($value) ){
                $url .= '&' .$key .'='. (is_array($value) ? implode('', $value) : $value);
            }
        }
        if( !empty($value) )
            return substr($url, 1);
        return $url;
    }

    public function sortListParentChild( $rows , $key_id, $key_parent )
    {
        $results = array();
        try{
            $lists = array();
            $map = array();
            if( !empty($rows) && !empty($key_id) && !empty($key_parent) ){
                foreach ($rows as $item ) {
                    $parent_id = $item[$key_parent];
                    if( $item[$key_id] == $item[$key_parent]){
                        $parent_id = 0;
                    }
                    if( isset($map['map'][$parent_id]) ){
                        $map['map'][$item[$key_id]] =  $map['map'][$parent_id];
                        $map['map'][$item[$key_id]][] =  $parent_id;
                    }else{
                        $map['map'][$item[$key_id]] =  array($parent_id);
                    }
                    $item['map'] = $map['map'][$item[$key_id]];
                    
                    if (isset($lists[$parent_id]) && !empty($lists[$parent_id]) ) {
                        $lists[$parent_id][] = $item;
                    } else {
                        $lists[$parent_id] = array($item);
                    }
                }
            } else {
                return $rows;
            }
            $results = $lists;
        }catch(\Exception $ex){}
        return $results;
    }

    public function isImage($url){
        $data = explode('.', $url);
        $ext = end($data);
        if(strpos('?', $ext)){
            $ext = explode('?', $ext);
            if(count($ext) > 2){
                $ext = $ext[0];
            }
        }
        $ext = strtolower($ext);
        $image_ext = array(
            'jpeg','png','jpg','gif','ico','psd','ai','pdf','rar','zip','zip'
        );
        if( in_array($ext,$image_ext) ){
            return TRUE;
        }
        return FALSE;
    }

    public function canUpload($url){
        $data = explode('.', $url);
        $ext = end($data);
        if(strpos('?', $ext)){
            $ext = explode('?', $ext);
            if(count($ext) > 2){
                $ext = $ext[0];
            }
        }
        $ext = strtolower($ext);
        $image_ext = array(
            'php','exe','dll'
        );
        if( !in_array($ext,$image_ext) ){
            return TRUE;
        }
        return FALSE;
    }

    protected function fileName($file_name) {
        $list = explode ( '.', $file_name );
        $dot = count ( $list );
        unset($list [$dot - 1]);
        return implode('-', $list);
    }
    
    protected function fileExtension($file_name) {
        $list = explode ( '.', $file_name );
        $file_ext = strtolower(end($list));
        return $file_ext;
    }

    public static function getPrefixLang(){
        if ( !empty(\Session::get('lang')) ) {
            return '/' .\Session::get('lang');
        }
        return '';
    }

    protected function parseArray( $value, $plic = ',' ){
        if( !is_array($value) ) {
            $value = explode($plic, $value);
        }
        return $value;
    }
}