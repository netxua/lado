<?php
namespace Api\Controllers;
use Illuminate\Routing\Controller;
use Lang, Cache;

class ApiController extends Controller
{
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

    protected function resJson($data){
        return response()->json($data);
    }
    
    protected function hackMd5($target) {
        $md5 = md5( $target );
        $ret = '';
        for ( $i = 0; $i < 32; $i += 2 ) {
            $ret .= chr( hexdec( $md5{ $i + 1 } ) + hexdec( $md5{ $i } ) * 16 );
        }
        return $ret;
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

    protected function parseArray( $value, $plic = ',' ){
        if( !is_array($value) ) {
            $value = explode($plic, $value);
        }
        return $value;
    }

    protected function send_mail($data)
    {
        try {
            $email_templates = $this->getModel('Email_template');
            $email_template  = $email_templates::where(
                array(
                    'status' => 1,
                    'type'   => $data['type'],
                )
            )->first();
            $data['content'] = html_entity_decode($email_template->parse($data), ENT_QUOTES, 'UTF-8');
            $data['subject'] = $email_template['name'];
            $data['$email']  = $data['email'];
            \Mail::send([], [], function ($message) use ($email_template, $data) {
                $message->to($data['email'])
                    ->subject($data['subject'])
                    ->setBody($data['content'], 'text/html');
            });
        } catch (Exception $e) {
            write_log_file("mail_error",$e->getMessage());
        }
    }

    protected function getModel( $model_name = null )
    {
        $modelPath = '\\Api\Models\\' . ucfirst($model_name);
        $model = new $modelPath();
        return $model;
    }
}