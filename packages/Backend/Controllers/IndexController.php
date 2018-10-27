<?php
namespace Backend\Controllers;
use App\Common\Library\FileManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use Backend\Models\ModelBase;
use Backend\Models\Users;
use Illuminate\Support\Facades\Auth;
use Lang, Cache;

class IndexController extends BackendController
{
    protected $layout = 'layouts.default';

    public function index_login(){
        if(Auth::check()){
           return $this->redirect("dashboard");
        }

        if(app()->make('request')->isMethod("post")){
            // validate the info, create rules for the inputs
            $rules = array(
                 'email'    => 'required',
                 'password' => 'required|alphaNum|min:3'
            );
            // run the validation rules on the inputs from the form
            $validator = \Validator::make(app()->make('request')->all(), $rules);
            if ($validator->fails()) {
                \Session::flash('message', 'The email or password you entered is incorrect');
                \Session::flash('alert-class', 'alert-danger');
                return $this->redirect("index");
            }else{
                $userData = array(
                    'email'     => app()->make('request')->get('email'),
                    'password'  => app()->make('request')->get('password')
                );
                // attempt to do the login
                if (\Auth::attempt($userData)) {
                    $users = $this->getModel("Users");
                    $result = $users::where(array(
                                        "email" => app()->make('request')->get('email')
                                    ))->first();
                    
                    if(!empty($result)){
                        $session_data = array(
                            'user_id' => $result->id,
                            'user_created_at' => $result->created_at,
                            'user_created_id' => $result->user_created_id,
                            'user_username' => $result->username,
                            'user_email' => $result->email,
                            'user_name' => $result->name,
                            'status' => $result->status,
                            'user_avatar' => $result->avatar,
                            'user_language' => "english"
                        );
                        app()->make('request')->session()->put('auth',$session_data);
                    }
                    return $this->redirect("dashboard");
                } else {
                    // validation not successful, send back to form
                    \Session::flash('message', 'The email or password you entered is incorrect');
                    \Session::flash('alert-class', 'alert-danger');
                    return $this->redirect('index');
                }
            }
        }
        return view('BackEnd::index/index');
    }

    public function index(){
        return $this->redirect("dashboard");
    }

    public function logout(){
        \Auth::logout();
       return $this->redirect("auth/login");
    }

    public function hashpass(){
        var_dump(\Hash::make('admin'));die();
    }
    
    public function test(){
        $FileManager = new FileManager();
    }
}