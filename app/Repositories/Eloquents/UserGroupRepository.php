<?php

namespace App\Repositories\Eloquents;

use App\Repositories\UserGroupRepositoryInterface;
use Exception;

class UserGroupRepository extends Repository implements UserGroupRepositoryInterface
{

    public $ruleAdd = [
        'group_id' => 'required',
        'user_id' => 'required'
    ];

    public $ruleUpdate = [
        'group_id' => 'required',
        'user_id' => 'required'
    ];

    public function createUserGroup($data)
    {
        $this->create($data);
    }

    public function updateUserGroup($id, $data)
    {
        $user_group = $this->findOrFail($id);
        $user_group->group_id = $data['group_id'];
        $user_group->user_id = $data['user_id'];
        $user_group->save();
    }
}
