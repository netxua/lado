<?php
namespace Frontend\Controllers;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Http\Request;
use Lang, Cache;

class IndexController extends FrontendController
{
    public function index(){
    	return  view('FrontEnd::index/index')->with($this->getDataView());
    }
}