<?php
namespace Api\Middleware;
use \Illuminate\Http\Request;
use Closure;

class PermissionApi
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $controller =  $request->segment(2);
        $action =  $request->segment(3) ? $request->segment(3) : 'index' ;
        $record = $request->segment(4);
        if($controller && $action) {
            $permission_data = array(
                'controller'=> $controller,
                'action'=> $action,
                'record'=>$record
            );
            $auth_session = $request->session()->get('auth');
            if($this->getGate($permission_data,$auth_session)){
                return $next($request);
            }else{
                $url = config('app.backendUrl');
                if($auth_session != null){
                    $url .= '/auth/denied';
                    return redirect()->guest($url);
                }
            }
        }
        return $next($request);
    }

    public function getGate($permission_data,$auth_session){
        return \Gate::allows('api_default',[$auth_session,$permission_data]);

    }
}