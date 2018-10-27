<?php
namespace Frontend\Middleware;
use \Illuminate\Http\Request;
use Closure;

class AuthenticateFrontend
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
    	if( empty($request->session()->get('_USER')) ){

            if( \Auth::guard('web')->check() ){
                $user = \Auth::guard('web')->user()->toArray();
                $user['user_id'] = $user['id'];
                $request->session()->put('_USER', $user);
            }
        }
        if( !empty(session()->has('lang')) ){
            \App::setLocale(session()->get('lang'));
        }else{
            \App::setLocale('vn');
        }
        return $next($request);
    }
}

