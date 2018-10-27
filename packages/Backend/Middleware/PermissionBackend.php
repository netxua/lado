<?php
/**
 * File :PermissionMiddleware.php
 * Created by: huyvh.
 * Email:huyvh19@gmail.com
 * Date: 11/4/16
 * Project: lar52-framework
 */

namespace Backend\Middleware;
use \Illuminate\Http\Request;
use Closure;

/**
 * Class PermissionBackend
 * @package Backend\Middleware
 */

class PermissionBackend
{
    /**
     * Function: handle
     * @param Request $request
     * @param Closure $next
     * @param null $guard
     * @return \Illuminate\Http\RedirectResponse
     */

    protected $roleExpect = array(
        'dashboard' => [
            'index'
        ],
        'auth' => [
            'login',
            'logout'
        ],
        'cities' => [
            'json-cities'
        ],
        'countries' => [
            'json-countries'
        ],
        'districts' => [
            'json-districts'
        ],
        'index' => [
            'index_login',
            'index',
            'logout'
        ],
        'pictures' => [
            'upload',
            'upload_file_copy'
        ],
        'wards' => [
            'json-wards'
        ]
    );

    public function hasRoleExpect( $controller, $action ){
        if ( !empty($this->roleExpect[$controller]) && in_array($action, $this->roleExpect[$controller]) ) {
            return TRUE;
        }
        return FALSE;
    }

    public function handle(Request $request, Closure $next, $guard = null)
    {
        $controller =  strtolower($request->segment(2));
        $action =  strtolower($request->segment(3, 'index'));
        if ( !$this->hasRoleExpect($controller, $action) 
                && !\HelperCommon::hasPermission('backend', $controller, $action) ) {
            $user = $request->session()->get('auth');
            if ( !empty($user) && empty($user['is_admin']) && !in_array($controller, ['auth', 'index', 'countries', 'cities', 'districts', 'wards']) ) {
                return redirect('/admin/dashboard')->send();
            }
        }
        return $next($request);
    }

    /**
     * Function: getGate
     * @param $permission_data
     * @param $auth_session
     * @return bool
     */
    public function getGate($permission_data,$auth_session){
        // get auth session data after login and check in AuthenticateBackend Middleware.
        return \Gate::allows('default',[$auth_session,$permission_data]);

    }
}