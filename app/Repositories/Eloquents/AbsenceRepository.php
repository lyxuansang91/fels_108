<?php

namespace App\Repositories\Eloquents;

use App\Repositories\AbsenceRepositoryInterface;
use Exception;

class AbsenceRepository extends Repository implements AbsenceRepositoryInterface
{

    public $ruleAdd = [
        'absence_day' => 'required',
        'level_id' => 'required',
        'subject_id' => 'required',
        'semester_id' => 'required',
        'student_id' => 'required'
    ];

    public $ruleUpdate = [
        'absence_day' => 'required',
        'subject_id' => 'required',
        'semester_id' => 'required',
        'student_level_id' => 'required'
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
        $student_level = \App\Models\StudentLevel::where('student_id', $data['student_id'])
            ->where('level_id', $data['level_id'])
            ->where('status', \App\Models\StudentLevel::ACTIVE)->first();
        if($student_level) {
            $data['student_level_id'] = $student_level->id;
            $absence = $this->create($data);
        } else {
            $absence = NULL;
        }
        return ($absence ? true : false);
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
        $absence->student_level_id = $data['student_level_id'];
        $absence->subject_id = $data['subject_id'];
        $absence->reason = $data['reason'];
        $absence->semester_id = $data['semester_id'];
        $absence->absence_day = $data['absence_day'];
        $absence->save();
    }

    public function getListAbsenceByLevelAndSemester($semester_id, $level_id) {
        $query = 'semester_id = ? and student_level_id in (select id from student_levels where
            level_id = ? and status = 1)';
        $absences = $this->model->whereRaw($query, array($semester_id,
            $level_id))->get();
        return $absences;
    }
}
