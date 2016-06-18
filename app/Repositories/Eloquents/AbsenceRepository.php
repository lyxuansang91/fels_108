<?php

namespace App\Repositories\Eloquents;

use App\Repositories\AbsenceRepositoryInterface;
use Exception;

class AbsenceRepository extends Repository implements AbsenceRepositoryInterface
{

    public $ruleAdd = [
        'absence_day' => 'required',
        'subject_id' => 'required',
        'semester_id' => 'required',
        'student_id' => 'required'
    ];

    public $ruleUpdate = [
        'absence_day' => 'required',
        'subject_id' => 'required',
        'semester_id' => 'required',
        'student_id' => 'required'
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
        $absence->subject_id = $data['subject_id'];
        $absence->reason = $data['reason'];
        $absence->semester_id = $data['semester_id'];
        $absence->absence_day = $data['absence_day'];
        $absence->save();
    }

    public function getListAbsenceByLevelAndSemester($semester_id, $level_id) {
        $query = 'semester_id = ? and student_id in (select id from students where
            level_id = ?)';
        $absences = $this->model->whereRaw($query, array($semester_id,
            $level_id))->get();
        return $absences;
    }
}
