<?php
namespace Api\Controllers;
use Backend\Models\Users as User;
use Illuminate\Http\Request;
use Lang, Cache;

class AuthController extends ApiController
{
    public function index(Request $request)
    {
    }

    public function register(Request $request)
    {
        $all = $request->all();
        if (empty($all['RegisterRequest']['email'])) {
            return response()->json([
                'RegisterReply' => array(
                    "codeReply" => array(
                        "codeID" => "400",
                        "codeName" => "Missing Email",
                    ),
                    "token" => "",
                ),
            ]);
        }
        if (empty($all['RegisterRequest']['password'])) {
            return response()->json([
                'RegisterReply' => array(
                    "codeReply" => array(
                        "codeID" => "400",
                        "codeName" => "Missing PassWord",
                    ),
                    "token" => "",
                ),
            ]);
        }
        if (empty($all['RegisterRequest']['phone'])) {
            return response()->json([
                'RegisterReply' => array(
                    "codeReply" => array(
                        "codeID" => "400",
                        "codeName" => "Missing phone",
                    ),
                    "token" => "",
                ),
            ]);
        }
        if (empty($all['RegisterRequest']['fullname'])) {
            return response()->json([
                'RegisterReply' => array(
                    "codeReply" => array(
                        "codeID" => "400",
                        "codeName" => "Missing full name",
                    ),
                    "token" => "",
                ),
            ]);
        }
        $RegisterRequest = $all['RegisterRequest'];
        $customers = $this->getApiModel('Customers');
        $result = $customers::where(array('email' => $RegisterRequest['email']))->first();
        if (!empty($result)) {
            return response()->json([
                'RegisterReply' => array(
                    "codeReply" => array(
                        "codeID" => "400",
                        "codeName" => "Email is exits",
                    ),
                    "token" => "",
                ),
            ]);
        }
        $customers = $this->getApiModel('Customers');
        $customers->email = $RegisterRequest['email'];
        $customers->fullname = $RegisterRequest['fullname'];
        $customers->password = $RegisterRequest['password'];
        $customers->phone = $RegisterRequest['phone'];
        $customers->province = $RegisterRequest['province'];
        $customers->sex = $RegisterRequest['sex'];
        $customers->username = $RegisterRequest['username'];
        if ($customers->save()) {
            $token = \JWTAuth::fromUser($customers);
            return response()->json([
                'LoginReply' => array(
                    "codeReply" => array(
                        "codeID" => "200",
                        "codeName" => "KHACH HANG MIEN PHI",
                    ),
                    "token" => $token,
                ),
            ]);
        } else {
            return response()->json([
                'RegisterReply' => array(
                    "codeReply" => array(
                        "codeID" => "400",
                        "codeName" => "Save customer failed",
                    ),
                    "token" => "",
                ),
            ]);
        }
    }
    protected function validateLogin(Request $request)
    {
        $rules = array(
            'email' => 'required',
            'password' => 'required',
        );
        return \Validator::make($request->all(), $rules);

    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $LoginRequest = $request->get('LoginRequest');
        $customers = $this->getApiModel('Customers');
        $customer = $customers::where(
            array(
                'username' => $LoginRequest['userName'],
                'password' => $LoginRequest['passWord'],
            )
        )->first();
        if (!$customer) {
            return response()->json([
                'LoginReply' => array(
                    "codeReply" => array(
                        "codeID" => "400",
                        "codeName" => "MAT KHAU KHONG DUNG",
                    ),
                    "token" => "",
                ),
            ]);
        }
        $token = \JWTAuth::fromUser($customer);
        return response()->json([
            'LoginReply' => array(
                "codeReply" => array(
                    "codeID" => "200",
                    "codeName" => "KHACH HANG MIEN PHI",
                ),
                "token" => $token,
            ),
        ]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getToken(Request $request)
    {
        $LoginRequest = $request->get('GetToken');
        $customers = $this->getApiModel('Customers');
        $customer = $customers::where(
            array(
                'customer_id' => $LoginRequest['userID'],
            )
        )->first();
        $token = "";
        if (empty($customer)) {
            $customers->customer_id = $LoginRequest['userID'];
            $customers->token = $LoginRequest['token'];
            if(!$customers->save()){
                return response()->json([
                    'GetTokenReply' => array(
                        "codeReply" => array(
                            "codeID" => "400",
                            "codeName" => "System Error",
                        ),
                        "token" => $token,
                    ),
                ]);
            }
            $token = \JWTAuth::fromUser($customers);
        }else{ 
            $customer->token = $LoginRequest['token'];
            if(!$customer->update()){
                return response()->json([
                    'GetTokenReply' => array(
                        "codeReply" => array(
                            "codeID" => "400",
                            "codeName" => "System Error",
                        ),
                        "token" => $token,
                    ),
                ]);
            }
            $token = \JWTAuth::fromUser($customer);
        }
        return response()->json([
            'GetTokenReply' => array(
                "codeReply" => array(
                    "codeID" => "200",
                    "codeName" => "",
                ),
                "token" => $token,
            ),
        ]);

    }


    public function get_user_details(Request $request)
    {

        $input = $request->all();

        $user = \JWTAuth::toUser($input['token']);

        return response()->json(['result' => $user]);

    }

}
