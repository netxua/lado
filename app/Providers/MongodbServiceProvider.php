<?php
namespace App\Providers;
use Jenssegers\Mongodb\MongodbServiceProvider as Base;
use Jenssegers\Mongodb\MongoConnector;

class MongodbServiceProvider extends Base{

    public function register()
    {
        $this->app->resolving('db', function ($db) {
            $db->extend('mongodb', function ($config, $name) {
                $config['name'] = $name;
                return new \Jenssegers\Mongodb\Eloquent\Connection($config);
            });
        });

        $this->app->resolving('queue', function ($queue) {
            $queue->addConnector('mongodb', function () {
                return new MongoConnector($this->app['db']);
            });
        });
    }
}
