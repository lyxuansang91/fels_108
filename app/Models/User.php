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
    protected $fillable = ['name', 'email', 'password', 'avatar', 'role', 'student_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    const ROLE_USER = 2;
    const ROLE_ADMIN = 1;
    const PER_PAGE = 10;

    public function userWords()
    {
        return $this->hasMany(UserWord::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }
    /**
     * Mutator for auto hash password
     * @param String $data
     */
    public function setPasswordAttribute($data)
    {
        $this->attributes['password'] = \Hash::make($data);
    }

    public function follows()
    {
        return $this->hasMany(Follow::class, 'followee_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function following()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    public function learnedWord()
    {
        return $this->userWords()->where('status', '=', 1);
    }

    public function checkFollowed()
    {
        return $this->follows()->where('follower_id', '=', auth()->id())->get();
    }
}
