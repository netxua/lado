<?php
namespace Backend\Controllers;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Lang, Cache;

class AuthController extends BackendController
{
    use RedirectsUsers;
    protected $redirectTo;

    public function __construct()
    {
        $this->redirectTo = config('app.backendUrl');
        parent::__construct();

    }

    public function login(Request $request){

        if( $request->isMethod('post') ){
            //$email = request()->get('email', '');echo $email;die();
            $validator = $this->validateLogin($request);
            if ($validator->fails()) {
                \Session::flash('message', trans('BackEnd::auth.failed'));
                \Session::flash('alert-class', 'alert-danger');
            }else{
                $credentials= $this->getCredentials($request);
                if( \Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember')) ){
                    //if ( empty($this->redirectPath()) ) {
                        return redirect()->to('admin/dashboard');
                    //}
                    //return redirect()->to($this->redirectPath());
                }else {
                    \Session::flash('message', trans('BackEnd::auth.failed'));
                    \Session::flash('alert-class', 'alert-danger');
                }
            }
        }
        $request->flash();
        return view('BackEnd::auth.login');
    }
    

    public function google(Request $request){
        $client = new \Google_Client();
        $client->addScope('https://www.googleapis.com/auth/adexchange.seller');
        $client->setApplicationName('google_login');
        $client->setAccessType('offline');
        $client->setApprovalPrompt ("force");
        $client->setScopes(array(
            'https://www.googleapis.com/auth/plus.me',
            'https://www.googleapis.com/auth/userinfo.email',
            'https://www.googleapis.com/auth/userinfo.profile',
        ));
        $client->setAuthConfigFile(storage_path().'/var/client_secret_company_login_google.json');
        $authUrl = $client->createAuthUrl();
        if (!empty(request()->get('code'))) {
            try{
                $client->authenticate(request()->get('code'));
                $google_oauthV2 = new \Google_Service_Oauth2($client);
                $google_user = $google_oauthV2->userinfo->get();
            }catch (\Exception $e){
                return $this->redirect('');
            }
            if($google_user->hd != "urekamedia.vn" && $google_user->hd != "urekamedia.com"){
                return $this->redirect('');
            }

            $users = $this->getModel('Users');
            $user = $users::where(array(
                'email' => $google_user->email,
                'deleted' => 0
            ))->first();

            if( !empty($user) ){
                //login success

                $credentials = [
                    'email'=> $user->email,
                    'password'=>$google_user->id
                ];
                if(\Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))){
                    return redirect()->intended($this->redirectPath());
                }else {
                    // validation not successful, send back to form
                    \Session::flash('message', trans('Login success!'));
                    \Session::flash('alert-class', 'alert-danger');
                }
                return redirect()->intended($this->redirectPath());
            }else if(!empty($user) and ($user->status == false)){
                //login failed but have exits email
                \Session::flash('message', trans('Account not register yet or not active yet. Pls contact your manager!'));
                \Session::flash('alert-class', 'alert-danger');
            }
            $request->flash();
            return view('BackEnd::auth.login');
        }
        return redirect($authUrl);
    }

    protected function validateLogin(Request $request)
    {
        $rules = array(
            $this->loginUsername()    => 'required',
            'password' => 'required|alphaNum|min:3'
        );
        return \Validator::make($request->all(),$rules);
    }

    public function loginUsername()
    {
        return property_exists($this, 'email') ? $this->username : 'username';
    }

    public function logout()
    {
        $user = $this->getUser();
        $user_id = \HelperUser::getUserId($user);
        \Auth::guard($this->getGuard())->logout();
        \Session::flush();
        $this->getModel('UserLog')->insertGetId(array(
                                    'users_id' => $user_id, 
                                    'ref_id' => $user_id,
                                    'log_type' => 'Auth',
                                    'log_action' => 'logout',
                                    'log_data' => json_encode($user),
                                    'created_at' => date('Y-m-d H:m:s')
                                ));
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : config('app.backendUrl').'/auth/login');
    }

    public function denied(){
        return View('BackEnd::auth.denied');
    }

    protected function getGuard()
    {
        return property_exists($this, 'guard') ? $this->guard : null;
    }

    protected function getCredentials(Request $request)
    {
        return $request->only($this->loginUsername(), 'password');
    }


}