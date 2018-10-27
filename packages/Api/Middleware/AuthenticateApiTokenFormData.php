<?php
namespace Api\Middleware;
use Api\Models\ApiKeys;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTFactory;
use Closure;
use Exception;
use JWTAuth;

class AuthenticateApiTokenFormData
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $all = $request->all();
        $token = $all['token'];
        $api_name = $all['api_name'];
        try {     
            $api_key = ApiKeys::where(array('key' => $token))->first();
            if(empty($api_key)){
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

