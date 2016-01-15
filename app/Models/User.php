<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'avatar', 'role'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public static $ruleAddUser = [
                                'email'             => 'required|email|unique:users,email',
                                'password'          => 'required|min:8',
                                'password_confirm'  => 'required|same:password',
                                'role'              => 'required',
                                ];

    public static function getAllUser()
    {
        $users = User::all();

        return $users;
    }

    public static function createAnUser($input)
    {
        $user = new User;
        $user->email = $input->email;
        $user->password = $input->password;
        $user->role = $input->role;
        $user->save();
    }
}
