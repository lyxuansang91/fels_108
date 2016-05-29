<?php

namespace App\Repositories\Eloquents;

use App\Repositories\SemesterRepositoryInterface;
use Exception;

class SemesterRepository extends Repository implements SemesterRepositoryInterface
{

    public $ruleAdd = [
        'name' => 'required'
    ];


    public function semesterSelection()
    {
        $semesters = $this->model->all();
        $semesterArray = array();
        foreach ($semesters as $semester) {
            $semesterArray[$semester->id] = $semester->name;
        }
        return $semesterArray;
    }

    public function createSemester($data)
    {
        // $file = $data['image'];
        // $name = $file->getClientOriginalName();
        // $file->move(public_path().'/images/category', $name);
        // $data['image'] = '/images/category/' . $name;
        $this->create($data);
    }

    public function updateSemester($id, $data)
    {
        $semester = $this->findOrFail($id);
        // if(isset($data['image'])) {
        //     $file = $data['image'];
        //     $name = $file->getClientOriginalName();
        //     $file->move(public_path().'/images/category', $name);
        //     $category->image = '/images/category/' . $name;
        // }
        // $category->name = $data['name'];
        // $category->content = $data['content'];
        $semester->name = $data['name'];
        $semester->save();
    }
}
