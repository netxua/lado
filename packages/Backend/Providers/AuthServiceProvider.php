<?php
namespace Backend\Providers;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('default',function($user,$alc_session,$permission_data){
            if(isset($user->is_admin) && $user->is_admin == 1){
                return true;
            }else{
                // dd($permission_data);
                $module = ucfirst($permission_data['controller']);
                $action = $permission_data['action'];
                $action = isset(Config('backend_config.map_acl_action_list')[$action]) ? Config('backend_config.map_acl_action_list')[$action] : null;

                $user_acl = $alc_session['role']['ACL'];

                //my_debug($user_acl[$module]);
                if(!empty($user_acl[$module])){
                    // have config permission for action.
                    if(isset($user_acl[$module][$action])){
                        $permission = $user_acl[$module][$action];
                        if($user_acl[$module][$action] == 0){
                            $permission = Config('backend_config.default_none_acl');
                        }
                        // for denied
                        if($permission == 4){
                            return false;
                        }
                        // for accept
                        else{
                            return true;
                        }
                    }
                }
                // if not set every thing, the system will be return true.
                return false;
            }
        }
    );

        $gate->define('depth',function($user,$alc_session,$permission_data){
            if(isset($user->is_admin) && $user->is_admin == 1){
                return true;
            }else{
                $module = ucfirst($permission_data['controller']);
                $action = $permission_data['action'];
                $action = isset(config('backend_config.map_acl_action_list')[$action]) ? config('backend_config.map_acl_action_list')[$action] : null;
                $create_user_id = $permission_data['create_user_id'];

                $user_acl = $alc_session['role']['ACL'];

                if(!empty($user_acl[$module])){

                    // have config permission for action.
                    if(isset($user_acl[$module][$action]) && $user_acl[$module][$action] != null){
                        $permission = $user_acl[$module][$action];
                        if($user_acl[$module][$action] == 0){
                            $permission = config('backend_config.default_none_acl');
                        }
                        // for denied
                        if($permission == 4){
                            return false;
                        }
                        // for group
                        elseif($permission == 3){
                            if(isset($alc_session['group'])){
                                $user_in_group = $alc_session['group'];
                            }else{
                                $user_in_group = array();
                            }
                            return in_array($create_user_id,$user_in_group['list']);
                        }
                        // for owner
                        elseif($permission == 2){
                            return $user->id === $create_user_id;
                        }
                        // for access
                        else{
                            return true;
                        }
                    }
                }
                // if not set every thing, the system will be return true.
                return true;
            }

        }
        );

    }
}
