<?php
namespace Backend\Middleware;
use Backend\Models\ACLRole;
use Backend\Models\Group;
use Backend\Models\Role;
use Backend\Models\UserGroup;
use Backend\Models\Users;
use \Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;
use Closure;

class AuthenticateBackend
{
    public $childUsers = array();
    public function getUserChild( $user )
    {
        if( !empty($user) ){
            $childs = \DB::table('users')->selectRaw('users.*, users.id AS user_id')
                            ->where(array(
                                'users.parent_id' => $user['id']
                            ))->get();
            foreach ($childs as $key => $child) {
                $child = (array)($child);
                $this->childUsers[] = $child;
                $this->getUserChild($child);
            }
        }
    }

    public $childRoleIds = array();
    public function getRolesChild( $roles_id )
    {
        if( !empty($roles_id) ){
            $childs = \DB::table('roles')->selectRaw('roles.roles_id')
                            ->where(array(
                                'roles.parent_id' => $roles_id
                            ))->get();
            foreach ($childs as $key => $child) {
                $child = (array)($child);
                if( !in_array($child['roles_id'], $this->childRoleIds) ){
                    $this->childRoleIds[] = $child['roles_id'];
                    $this->getRolesChild($child['roles_id']);
                }
            }
        }
    }

    public function handle(Request $request, Closure $next, $guard = null)
    {
        if( !\Auth::check() ){
            if( strpos($request->getUri(),'/auth/login') === false ){
                $url = \Config::get('app.backendUrl');
                $url .= '/auth/login';
                return redirect()->guest($url);
            }
        } else {
            if( $request->session()->get('auth') == null ){
                $u = \Auth::getUser()->toArray();
                if ( empty($u['id']) || empty($u['type']) || $u['type'] != 'admin' ) {
                    \Auth::guard('web')->logout();
                    \Session::flush();
                    $url = \Config::get('app.backendUrl');
                    $url .= '/auth/login';
                    return redirect()->guest($url);
                }
                $user = \Auth::getUser()->selectRaw('users.*, users.id AS user_id,
                                    roles.roles_name, roles.roles_type')
                                ->leftJoin('roles', 'roles.roles_id', '=', 'users.roles_id')
                                ->where(array(
                                    'users.id' => $u['id']
                                ))
                                ->get()->first();

                $user['user_language'] = config('app.locale','vn');

                $this->childUsers[] = $user;
                $this->getUserChild($user);
                $this->childRoleIds = array(
                    $user['roles_id']
                );
                //$this->getRolesChild($user['roles_id']);

                $childId = array();
                foreach ($this->childUsers as $key => $child) {
                    $childId[] = $child['user_id'];
                }
                //$user['children'] = $this->childUsers;
                $user['childrenID'] = $childId;
                $user['rolesIds'] = $this->childRoleIds;
                
                $pers = \DB::table('modules')->selectRaw('modules.*,
                        roles.roles_name, roles.roles_description')
                        ->join('groups', function($join){
                            $join->on(DB::raw(" find_in_set(modules.module_id, groups.module) "), \DB::raw(''), \DB::raw('')); 
                        })
                        ->join('roles', function($join){
                            $join->on(DB::raw(" find_in_set(groups.groups_id, roles.groups) "), \DB::raw(''), \DB::raw('')); 
                        })
                        ->whereIn('roles.roles_id', $this->childRoleIds)
                        ->orWhere('roles.roles_id', '=', $user['roles_id'])->get();

                $permissions = array();
                $rtypes = array();
                if( !empty($pers) ){
                    foreach ($pers as $key => $per) {
                        $per = (array)($per);
                        $irtype = $per['roles_type'];
                        $imodule = strtolower($per['module']);
                        $icontroller = strtolower($per['controller']);
                        $iaction = strtolower($per['action']);
                        if( !empty($imodule) 
                            && !empty($icontroller) && !empty($iaction) ) {
                            if( !isset($permissions[$imodule]) ){
                                $permissions[$imodule] = array();
                            }
                            if( !isset($permissions[$imodule][$icontroller]) ){
                                $permissions[$imodule][$icontroller] = array();
                            }
                            $permissions[$imodule][$icontroller][] = $iaction;
                        }
                    }
                }
                $user['permissions'] = $permissions;

                \DB::table('users_log')->insertGetId(array(
                    'users_id' => $user['user_id'], 
                    'ref_id' => $user['user_id'],
                    'log_type' => 'Auth',
                    'log_action' => 'login',
                    'log_data' => json_encode($user),
                    'created_at' => date('Y-m-d H:m:s')
                ));
                $request->session()->put('auth', $user);
            }
        }
        return $next($request);
    }
}