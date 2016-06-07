<?php

namespace App\Repositories\Eloquents;

use App\Repositories\AbsenceRepositoryInterface;
use Exception;

class AbsenceRepository extends Repository implements AbsenceRepositoryInterface
{

    public $ruleAdd = [
        'absence_name' => 'required',
        'grade_id' => 'required',
        'group_id' => 'required'
    ];

    public $ruleUpdate = [
        'absence_name' => 'required',
        'grade_id' => 'required',
        'group_id' => 'required'
    ];


    public function absenceSelection()
    {
    }

    public function createAbsence($data)
    {
        // $file = $data['image'];
        // $name = $file->getClientOriginalName();
        // $file->move(public_path().'/images/category', $name);
        // $data['image'] = '/images/category/' . $name;
        $this->create($data);
    }

    public function updateAbsence($id, $data)
    {
        $absence = $this->findOrFail($id);
        // if(isset($data['image'])) {
        //     $file = $data['image'];
        //     $name = $file->getClientOriginalName();
        //     $file->move(public_path().'/images/category', $name);
        //     $category->image = '/images/category/' . $name;
        // }
        // $category->name = $data['name'];
        // $category->content = $data['content'];
        $absence->student_id = $data['student_id'];
        $absence->teacher_id = $data['teacher_id'];
        $absence->reason = $data['reason'];
        $absence->semester_id = $data['semester_id'];
        $absence->save();
    }
}
