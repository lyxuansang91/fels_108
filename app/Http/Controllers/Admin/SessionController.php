<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Repositories\UserRepositoryInterface as UserRepository;



class SessionController extends Controller
{

    protected $userRepo;
    
    public function __construct( UserRepository $userRepo) 
    {
        $this->userRepo = $userRepo;
    }
 
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    public function index()
    {
        return view('admin.login');
    }

    public function store(Request $request)
    {
        $rule = $this->userRepo->ruleLogin;
        
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return \Redirect::route('admin.login.index')->with(['errors'=>$errors]);
        }
        $auth = \Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if($auth) {
            
            return redirect()->route('index');
        } else {
            
            return redirect()->route('admin.login.index')->withMessages('Email or Password is incorrect'); 
        }
    }

    public function destroy()
    {
        \Auth::logout();

        return redirect()->route('admin.login.index');
    }
}
