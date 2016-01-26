<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryInterface as UserRepository;


class UserController extends Controller
{
    protected $userRepo;
    
    public function __construct( UserRepository $userRepo) 
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = $this->userRepo->ruleCreate;
        
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return redirect()->route('user.profile.create')->with(['errors' => $errors]);
        }
        $this->userRepo->registerUser($request->all());

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userRepo->findOrFail($id);
        // dd(count($user->follow));
        
        return view('user.profile.showProfile')->with(['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(\Auth::id() != $id) {
            return redirect()->route('user.index');
        }

        $user = $this->userRepo->findOrFail($id);

        return view('user.profile.editProfile')->with(['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rule = $this->userRepo->ruleUpdate;
        $rule['email'] .= ',' . $id;
        unset($rule['role']);
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return \Redirect::route('user.profile.edit', $id)->with(['errors' => $errors]);
        }
        $data = $request->all();
        $data['role'] = User::ROLE_USER;
        $this->userRepo->updateProfile($id, $data);

        return redirect()->route('user.profile.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}