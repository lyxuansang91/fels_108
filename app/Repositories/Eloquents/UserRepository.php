<?php

namespace App\Repositories\Eloquents;
 
use App\Repositories\UserRepositoryInterface;
use Exception;

class UserRepository extends Repository implements UserRepositoryInterface
{
    /**
     * Validate's rule for login by Admin
     * @var Array $ruleLogin
     */
    public $ruleLogin = [
        'email' => 'required|email',
        'password' => 'required|min:8'  
    ];

    public $ruleAddUser = [
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'password_confirm' => 'required|same:password',
        'role' => 'required',
    ];

    public $ruleUpdate = [
        'email' => 'required|email|unique:users,email',
        'name' => 'required',
        'role' => 'required'
    ];

    public function updateProfile($id, $data)
    {
        $user = $this->findOrFail($id);
        if(isset($data['avatar'])) {
            $file = $data['avatar'];
            $name = $file->getClientOriginalName();
            $file->move(public_path().'/images/avatar', $name);
            // dd($name);    
            $user->avatar = '/images/avatar/' . $name;
        }
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];
        $user->save();

        return $user;
    }

    public function updatePassword($id, $password)
    {
        $user = $this->findOrFail($id);
        $user->password = \Hask::make($password);
        $user->save();

        return $user;
    }

    public function getListMember()
    {
        $users = $this->model->where('role', '=', \App\Models\User::ROLE_USER)->orderBy('created_at', 'desc')->get();

        return $users;
    }

    public function create($data)
    {
        if(!isset($data['avatar']) || $data['avatar'] == '') {
            $data['avatar'] = '/images/avatar/default.png';
        }

        return $this->model->create($data);
    }
}