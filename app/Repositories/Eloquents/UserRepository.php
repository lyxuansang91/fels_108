<?php

namespace App\Repositories\Eloquents;

use App\Repositories\UserRepositoryInterface;
use Exception;
use \App\Models\User;
use \App\Models\Student;


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

    public $ruleCreate = [
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'password_confirm' => 'required|same:password',
        'student_id' => 'required'
    ];

    public $rulePassword = [
        'current_password' => 'required|min:8',
        'new_password' => 'required|min:8',
        'new_password_confirm' => 'required|same:new_password',
    ];

    public function updateProfile($id, $data)
    {
        $user = $this->findOrFail($id);
        if(isset($data['avatar'])) {
            $file = $data['avatar'];
            $name = $file->getClientOriginalName();
            $file->move(public_path().'/images/avatar', $name);
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
        $user->password = $password;
        $user->save();

        return $user;
    }


    public function userSelection()
    {
        $users = $this->model->all();
        $userArray = array();
        foreach ($users as $user) {
            $userArray[$user->id] = $user->email;
        }
        return $userArray;
    }


    public function getListMember()
    {
        $users = $this->model->where('role', '=', User::ROLE_USER)->orderBy('created_at', 'desc')->paginate(User::PER_PAGE);

        return $users;
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function registerUser($data)
    {
        $data['role'] = User::ROLE_USER;
        $student_id = $data['student_id'];
        $student = Student::find($student_id);
        if($student) {
            $user = $this->model->create($data);
            $student->user_id = $user->id;
            $student->save();
        }
    }

    public function searchListMember($data)
    {
        $users = $this->model->where('role', '=', User::ROLE_USER)
            ->where('name', 'LIKE', '%' . $data . '%')
            ->paginate(User::PER_PAGE);

        return $users;
    }
}
