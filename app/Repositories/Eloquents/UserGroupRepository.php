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


    // public function levelSelection()
    // {
    //     $levels = $this->model->all();
    //     $levelArray = array();
    //     foreach ($levels as $level) {
    //         $levelArray[$level->id] = $level->level_name;
    //     }
    //     return $levelArray;
    // }

    public function createUserGroup($data)
    {
        // $file = $data['image'];
        // $name = $file->getClientOriginalName();
        // $file->move(public_path().'/images/category', $name);
        // $data['image'] = '/images/category/' . $name;
        $this->create($data);
    }

    public function updateUserGroup($id, $data)
    {
        $user_group = $this->findOrFail($id);
        // if(isset($data['image'])) {
        //     $file = $data['image'];
        //     $name = $file->getClientOriginalName();
        //     $file->move(public_path().'/images/category', $name);
        //     $category->image = '/images/category/' . $name;
        // }
        // $category->name = $data['name'];
        // $category->content = $data['content'];
        $user_group->group_id = $data['group_id'];
        $user_group->user_id = $data['user_id'];
        $user_group->save();
    }
}
