<?php

namespace App\Repositories\Eloquents;

use App\Repositories\GradeRepositoryInterface;
use Exception;

class GradeRepository extends Repository implements GradeRepositoryInterface
{

    public $ruleAdd = [
        'grade_name' => 'required'
    ];


    public function gradeSelection()
    {
        $grades = $this->model->all();
        $gradeArray = array();
        foreach ($grades as $grade) {
            $gradeArray[$grade->id] = $grade->grade_name;
        }

        return $gradeArray;
    }

    public function createGrade($data)
    {
        // $file = $data['image'];
        // $name = $file->getClientOriginalName();
        // $file->move(public_path().'/images/category', $name);
        // $data['image'] = '/images/category/' . $name;
        $this->create($data);
    }

    public function updateGrade($id, $data)
    {
        $grade = $this->findOrFail($id);
        // if(isset($data['image'])) {
        //     $file = $data['image'];
        //     $name = $file->getClientOriginalName();
        //     $file->move(public_path().'/images/category', $name);
        //     $category->image = '/images/category/' . $name;
        // }
        // $category->name = $data['name'];
        // $category->content = $data['content'];
        $grade->grade_name = $data['grade_name'];
        $grade->save();
    }
}
