<?php
namespace Frontend\Models;
use Illuminate\Support\Facades\DB;
Use Libraries\Baymax\core AS Baymax;
use Lang, Cache;

class Language extends App
{
    protected $table = 'languages';
    public    $timestamps = true;

    public function getLanguages() {
    	return array();
    }
}