<?php
namespace Backend\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use Doctrine\DBAL\Schema\View;
//use Illuminate\Database\Eloquent\Model;
use igaster\laravelTheme\Facades\Theme;
use Illuminate\Routing\Route;
Use Illuminate\Support\Facades\DB;
use Lang, Cache;

class BackendController extends Controller
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
    protected $layout = 'default';
    protected $languages = array();
    protected $lang = 'vn';
    protected $langId = 1;

    public function __construct(){
        $this->middleware('AuthenticateBackend',['expect'=>['login','logout','denied']]);
        $this->beforeExecuteRoute();
        if( !empty(app()->make('request')->session()->has('auth')) ){
            $this->user = app()->make('request')->session()->get('auth');
        }
        $this->referer = \Request::server('HTTP_REFERER');
        $this->website =  $this->getModel('Website')->get()->first();
        if ( empty($this->website) ) {
            die('Not found website');
        }
        Theme::configSet('title', $this->website->erp_name);
        $this->languages =  $this->getModel('Language')->getLanguages();
        if( request()->session()->has('lang') ){
            $this->lang = request()->session()->get('lang');
        }
        view()->share('lang', $this->lang);
        view()->share('website', $this->website);
        view()->share('current_user', $this->user);
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
        $this->addDataView('_keywords', $_keywords);
    }

    public function beforeExecuteRoute()
    {
        $this->controller_name = strtolower(app()->make('request')->segment(2, ''));
        $this->action_name = strtolower(app()->make('request')->segment(3, 'index'));
    }

    protected function checkPermission($auth_session,$permission_data){

        return \Gate::allows('depth',[$auth_session,$permission_data]);
    }

    public function authPermission( $create_user_id ){
        $auth_session = session('auth');
        $permission_data = array(
            'controller'=>$this->controller_name,
            'action'=> $this->action_name,
            'create_user_id' => $create_user_id,
        );
        if( !$this->checkPermission($auth_session,$permission_data) ){

            return false;
        }

        return true;

    }

    protected function getSubPanels($defs, $data)
    {
        $sub_panels = array();
        foreach ($defs as $name => $def) {
            $sub_panels[$name] = $this->getSubPanel($def, $data);
        }

        return $sub_panels;
    }


    protected function getSubPanel($def, $data)
    {
        $panel = array();

        if ($def['type'] == 'one-many') {
            $panel = \DB::table($def['rel_table'])
                ->where($def['rel_field'],'=',$data->id)
                ->where('deleted','=',0)
                ->paginate(config("backend_config.list_record_number",10))
            ;

        } else if ($def['type'] == 'many-many') {
            $panel = \DB::table($def['mid_table'])
                ->join($def['current_table'],$def['mid_table'].'.'.$def['mid_field1'],'=',$def['current_table'].'.'.$def['current_field'])
                ->join($def['rel_table'],$def['mid_table'].'.'.$def['mid_field2'],'=',$def['rel_table'].'.'.$def['rel_field'])
                ->select(
                    $def['mid_table'].'.'.'*',
                    $def['current_table'].'.'.'name as '.$def['current_table'].'_name',
                    $def['rel_table'].'.'.'name as '.$def['rel_table'].'_name'
                )
                ->where($def['mid_table'].'.'.$def['mid_field1'],'=',$data->id)
                ->where($def['mid_table'].'.deleted','=',0)
                ->paginate(config("backend_config.list_record_number",10));
        }

        return $panel;
    }

    protected function deleteRecord($id, $model_name = null)
    {
        $model = $this->getModel($model_name);
        $data = $model::find($id);

        if(!empty($data)){

            $data->deleted = 1;
            return $data->update();
        }else{
            return false;
        }

    }
    
    /*new*/
    public function redirect($url = null){
        return \Redirect::to(\Config::get('app.backendUrl').'/'.$url);
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
            if( !empty($value) && !in_array($key, ['page']) ){
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

    private function getSubLevelList( $rows , $sort, $key_id = '', $level = 0 )
    {
        $results = array();
        if( !empty($rows) && !empty($sort) ){
            foreach ($rows as $k => $row) {
                $row['level_indent'] = $level;
                if( !empty($sort[$row[$key_id]]) ){
                    $row['level_end'] = 0;
                    $results[] = $row;
                    $subResults = $this->getSubLevelList($sort[$row[$key_id]], $sort, $key_id, ($level+1));
                    $results = array_merge($results, $subResults);
                } else {
                    $row['level_end'] = 1;
                    $results[] = $row;
                }
            }
        }
        return $results;
    }

    public function getLevelList( $rows , $key_id, $key_parent, $start = 0 )
    {
        $results = array();
        if( !empty($rows) ){
            $sort = $this->sortListParentChild($rows , $key_id, $key_parent);
            //$results = $this->getSubLevelList($sort[$start], $sort, $key_id, $start);
            $keys = array_keys($sort);
            foreach ($rows as $ki => $irows) {
                $keyid = $irows[$key_id];
                if ( ($key = array_search($keyid, $keys)) !== false ) {
                    unset($keys[$key]);
                }
            }
            foreach ( $keys as $sv ) {
                $iresults = $this->getSubLevelList($sort[$sv], $sort, $key_id, 0);
                $results = array_merge($results, $iresults);
            }
        }
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

    protected function file_name($file_name) {
        $list = explode ( '.', $file_name );
        $dot = count ( $list );
        unset($list [$dot - 1]);
        return implode('-', $list);
    }
    
    protected function file_extension($file_name) {
        $list = explode ( '.', $file_name );
        $file_ext = strtolower(end($list));
        return $file_ext;
    }

    protected function parseArray( $value, $plic = ',' ){
        if( !is_array($value) ) {
            $value = explode($plic, $value);
        }
        return $value;
    }
}
