<?php

namespace App\Repositories\Eloquents;

use App\Repositories\GroupRepositoryInterface;
use Exception;

class GroupRepository extends Repository implements GroupRepositoryInterface
{

    public $ruleAdd = [
        'group_name' => 'required'
    ];


    public function groupSelection()
    {
        $groups = $this->model->all();
        $groupArray = array();
        foreach ($groups as $group) {
            $groupArray[$group->id] = $group->group_code;
        }
        return $groupArray;
    }

    public function createGroup($data)
    {
        // $file = $data['image'];
        // $name = $file->getClientOriginalName();
        // $file->move(public_path().'/images/category', $name);
        // $data['image'] = '/images/category/' . $name;
        $this->create($data);
    }

    public function updateGroup($id, $data)
    {
        $group = $this->findOrFail($id);
        // if(isset($data['image'])) {
        //     $file = $data['image'];
        //     $name = $file->getClientOriginalName();
        //     $file->move(public_path().'/images/category', $name);
        //     $category->image = '/images/category/' . $name;
        // }
        // $category->name = $data['name'];
        // $category->content = $data['content'];
        $group->group_name = $data['group_name'];
        $group->group_code = $data['group_code'];
        $group->save();
    }
}
