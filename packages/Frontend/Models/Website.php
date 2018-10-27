<?php
namespace Frontend\Models;
use Illuminate\Support\Facades\DB;
Use Libraries\Baymax\core AS Baymax;
use Lang, Cache;

class Website extends App
{
    protected $table = 'website';
    public    $timestamps = true;

    public function getWebsite() {
    	return (new Baymax())->getWebsite()->remember('website', function(){
            return $this->getModel('Website')->first();
        });
    }
}