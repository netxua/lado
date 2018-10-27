<?php
/**
 * Created by PhpStorm.
 * User: huyvh
 * Date: 10/6/17
 * Time: 11:50 AM
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BaseCommand extends Command
{
    /**
     * Function: getModel
     * @param null $model_name
     * @return ModelBase|null
     */
    protected $model_name = null;
    /**
     * @param $site_name
     * @return bool
     * @function insert_update_sites
     * @By: huyvh
     * @Created: 2017/10/02
     * @Updated: 201710/02
     */
    protected function insert_update_sites($site_name)
    {
        $sites = $this->getModel('Sites');
        $site = $sites::where(
            array(
                "deleted" => 0,
                "status" => 1,
                "name" => $site_name,
            )
        )->first(['id']);
        if (empty($site)) {
            $sites->user_created_id = 1;
            $sites->name = $site_name;
            $sites->publisher_id = 0;
            $sites->status = 1;
            if ($sites->save()) {
                return $sites->id;
            } else {
                print_r("\n Errors save news sites ad_tags = " . $site_name);
                write_log_file(
                    "cron_api_errors",
                    "Errors save news sites ad_tags = " . $site_name,
                    "error"
                );
                return false;
            }
        } else {
            return $site->id;
        }
        return false;
    }
    protected function getModel($model_name = null)
    {
        $model_focus = $this->model_name;
        if ($model_name) {
            $model_focus = $model_name;
        }
     
        if ($model_focus) {
            $model_path = '\\Backend\Models\\' . ucfirst($model_focus);
            $model = new $model_path();
            /**
             * @var ModelBase $model
             */
            return $model;
        }else{
            return null;
        }
    }
    //Model final
    protected function getModelFinal($model_name = null)
    {
        $model_focus = $this->model_name;
        if ($model_name) {
            $model_focus = $model_name;
        }
     
        if ($model_focus) {
            $model_path = '\\Finance\Models\\' . ucfirst($model_focus);
            $model = new $model_path();
            /**
             * @var ModelBase $model
             */
            return $model;
        }else{
            return null;
        }
    }
}