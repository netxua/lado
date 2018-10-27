<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use PHPImageWorkshop\ImageWorkshop;
use PHPImageWorkshop\ImageWorkshopException;
use PHPImageWorkshop\Core\Exception\ImageWorkshopLayerException as ImageWorkshopLayerException;

class Images {
	public static function getUrlImage($url,$width=null, $height=null, $scrop = false, $bacground = 'ffffff'){
        $websiteFolder = PATH_BASE_ROOT . '/custom';
        if(!is_dir($websiteFolder)){
            @mkdir ( $websiteFolder, 0777 );
        }
        $websiteThumb = $websiteFolder.'/thumb';
        if(!is_dir($websiteThumb)){
            @mkdir ( $websiteThumb, 0777 );
        }
        $result = '/admin/image/placeholder';
        if(!empty($url)){
            if( is_file(PATH_BASE_ROOT.$url) ){
                $result = $url;
                $thumbFolder = '';
                if(!empty($width)){
                    $thumbFolder = $width;
                }
                if(!empty($height)){
                    $thumbFolder = $thumbFolder.'x'.$height;
                }
                if( !empty($thumbFolder) ){
                    $websiteThumb = $websiteThumb.'/'.$thumbFolder;
                    if(!is_dir($websiteThumb)){
                        @mkdir ( $websiteThumb, 0777 );
                    }
                    $name = Images::getFileName($url);
                    $extension = Images::getFileExtension($name);
                    $result = '/custom/thumb/'.$thumbFolder.'/'.$name;
                    if( !is_file(PATH_BASE_ROOT.$result) ){
                        try{
							
                            $layer = ImageWorkshop::initFromPath(PATH_BASE_ROOT.$url);
                            //if( empty(Images::view->Websites()->getTypeCropImage()) ){
                                $largestSide = $width;
                                if( (empty($width) && !empty($height))
                                    || (!empty($width) && !empty($height) && ($height > $width)) ){
                                    $largestSide = $height;
                                }
                                if( !empty($largestSide) ){
                                    $layerWidth = $layer->getWidth();
                                    $layerHeight = $layer->getHeight();

                                    if( !empty($width) && !empty($height) ){
                                        $thumb_width = $width;
                                        $thumb_height = $height;
                                        $original_aspect = $layerWidth / $layerHeight;
                                        $thumb_aspect = $thumb_width / $thumb_height;
                                        if ( $original_aspect >= $thumb_aspect )
                                        {
                                           $new_height = $thumb_height;
                                           $new_width = $layerWidth / ($layerHeight / $thumb_height);
                                        }else{
                                           $new_width = $thumb_width;
                                           $new_height = $layerHeight / ($layerWidth / $thumb_width);
                                        }
                                    }else if(!empty($width) && empty($height)){
                                        $thumb_width = $width;
                                        $new_width = $thumb_width;
                                        $new_height = $layerHeight / ($layerWidth / $thumb_width);
                                        $thumb_height = $new_height;
                                    }else if( empty($width) && !empty($height)){
                                        $thumb_height = $height;
                                        $new_height = $thumb_height;
                                        $new_width = $layerWidth / ($layerHeight / $thumb_height);
                                        $thumb_width = $new_width;
                                    }

                                    $layer->resizeInPixel($new_width, $new_height);
                                    $layer->cropInPixel($thumb_width, $thumb_height, 0, 0, 'MM');
                                }else{
                                    $layer->resizeInPixel($width, $height, true, 0, 0, 'MM');
                                }
                                
                                $backgroundColor = null;
                                if( strtolower($extension) != 'png' ){
                                    $backgroundColor = $bacground;
                                }

                            /*}else{
                                $layerWidth = $layer->getWidth();
                                $layerHeight = $layer->getHeight();
                                if( !empty($width) && empty($height) ){
                                    $height = $layerHeight / ($layerWidth / $width);
                                }else if( empty($width) && !empty($height)){
                                    $width = $layerWidth / ($layerHeight / $height);
                                }
                                $layer->resizeInPixel($width, $height, true, 0, 0, 'MM');
                                $backgroundColor = null;
                                if( strtolower($extension) != 'png' ){
                                    $backgroundColor = $bacground;
                                }
                            }*/
                            
                            $layer->save($websiteThumb, $name, true, $backgroundColor, 80); 
                        } catch (\Exception $e) {
                            $result = '/admin/image/placeholder?dx='.$thumbFolder;
                        } catch (\ImageWorkshopException $e) {
                            $result = '/admin/image/placeholder?dx='.$thumbFolder;
                        } catch (\ImageWorkshopLayerException $e) {
                            $result = '/admin/image/placeholder?dx='.$thumbFolder;
                        }
                    }
                }
            }else{
                $result = $url;
            }
        }else{
            $size = '';
            if(!empty($width)){
                $size = $width;
            }
            if(!empty($height)){
                $size = $size.'x'.$height;
            }
            $result = '/admin/image/placeholder?dx='.$size;
        }
        return $result;
    }

    public static function getFileName($url) {
        $list = explode('/', $url);
        $image_name = end($list);
        return $image_name;
    }

    public static function getRealPath($url) {
        return url('').$url;
    }

    public static function getMimeType($url) {
        $ext = Images::getFileExtension($url);
        $mimeTypes = array(
            'gif' => 'image/gif',
            'png' => 'image/png',
            'jpg' => 'image/jpg',
            'css' => 'text/css',
            'js' => 'text/javascript',
        );
        return $mimeTypes[$ext];
    }

    public static function getFileExtension($url) {
        $list = explode ( '.', $url );
        $file_ext = strtolower(end($list));
        return $file_ext;
    }

    public static function getUrlPreviewWithType($url){
        $ext = Images::getFileExtension($url);
        if ( !in_array($ext, ['jpeg','png','jpg','gif','ico'])) {
            return '/admin/image/placeholderFile?dx=50&type=' .$ext. '&text=';
        }
        return $url;
    }

    public static function isImage($url){
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
            'jpeg','png','jpg','gif',
        );
        if(in_array($ext,$image_ext)){
            return TRUE;
        }
        return FALSE;
    }
}
