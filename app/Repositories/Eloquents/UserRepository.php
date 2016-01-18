<?php

namespace App\Repositories\Eloquents;
 
use App\Repositories\UserRepositoryInterface;
use Exception;

class UserRepository extends Repository implements UserRepositoryInterface
{
    public function updateProfile($id, $data)
    {
        $user = $this->findOrFail($id);
        $user->name = $data['name'];
        $user->email = $data['email'];
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
}