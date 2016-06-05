<?php

namespace App\Repositories\Eloquents;

use App\Repositories\SemesterRepositoryInterface;
use Exception;

class SemesterRepository extends Repository implements SemesterRepositoryInterface
{

    public $ruleAdd = [
        'semester_number' => 'required',
        'year' => 'required'
    ];


    public function semesterSelection()
    {
        $semesters = $this->model->all();
        $semesterArray = array();
        foreach ($semesters as $semester) {
            $semesterArray[$semester->id] = $semester->year.'-'.$semester->semester_number;
        }
        return $semesterArray;
    }

    public function createSemester($data)
    {
        // $file = $data['image'];
        // $name = $file->getClientOriginalName();
        // $file->move(public_path().'/images/category', $name);
        // $data['image'] = '/images/category/' . $name;
        $data['semester_code'] = $data['year'].'-'.$data['semester_number'];
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
        $semester->semester_number = $data['semester_number'];
        $semester->year = $data['year'];
        $semester->semester_code = $data['year'].'-'.$data['semester_number'];
        $semester->save();
    }
}
