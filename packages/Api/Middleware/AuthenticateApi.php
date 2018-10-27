<?php
namespace Api\Middleware;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTFactory;
use Closure;
use Exception;
use JWTAuth;

class AuthenticateApi
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $api_name = $request->input('api_name');
        try {
            if (!\JWTAuth::toUser($request->input('token'))) {
                return response()->json(array(
                    $api_name."Reply" => array(
                        "codeReply" => array(
                            "codeID" => "400",
                            "codeName" =>  "Token is Invalid"
                        )
                    )
                ));
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(array(
                    $api_name."Reply" => array(
                        "codeReply" => array(
                            "codeID" => "400",
                            "codeName" =>  "Token is Invalid"
                        )
                    )
                ));
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(array(
                    $api_name."Reply" => array(
                        "codeReply" => array(
                            "codeID" => "400",
                            "codeName" =>  "Token is Expired"
                        )
                    )
                ));
            } else {
                return response()->json(array(
                    $api_name."Reply" => array(
                        "codeReply" => array(
                            "codeID" => "400",
                            "codeName" =>  "Missing token"
                        )
                    )
                ));
            }
        }
        return $next($request);
    }
}

