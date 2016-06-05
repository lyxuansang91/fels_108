<?php

namespace App\Repositories\Eloquents;

use App\Repositories\PointRepositoryInterface;
use App\Models\SemesterSubjectLevel;
use App\Models\Semester;
use Exception;

class PointRepository extends Repository implements PointRepositoryInterface
{

    public $ruleAdd = [
        'semester_subject_level_id' => 'required',
        'user_id' => 'required'
    ];

    public $ruleUpdate = [
        'semester_subject_level_id' => 'required',
        'user_id' => 'required'
    ];

    public function createPoint($data)
    {
        $this->create($data);
    }

    public function updatePoint($id, $data)
    {
        $point = $this->findOrFail($id);
        $point->mark_m1 = $data['mark_m1']?$data['mark_m1']:NULL;
        $point->mark_m2 = $data['mark_m2']?$data['mark_m2']:NULL;
        $point->mark_m3 = $data['mark_m3']?$data['mark_m3']:NULL;
        $point->mark_m4 = $data['mark_m4']?$data['mark_m4']:NULL;
        $point->mark_15_1 = $data['mark_15_1']?$data['mark_15_1']:NULL;
        $point->mark_15_2 = $data['mark_15_2']?$data['mark_15_2']:NULL;
        $point->mark_15_3 = $data['mark_15_3']?$data['mark_15_3']:NULL;
        $point->mark_45_1 = $data['mark_45_1']?$data['mark_45_1']:NULL;
        $point->mark_45_2 = $data['mark_45_2']?$data['mark_45_2']:NULL;
        $point->mark_last = $data['mark_last']?$data['mark_last']:NULL;
        if($point->save()) return 200; else return 500;
    }

    public function getListPointByUser($user_id) {
        $points = $this->model->where('user_id', '=', $user_id)->orderBy('created_at', 'desc')->get();
        return $points;
    }


    public function getAllPoint() {
        $points = array();
        $semester = Semester::all()->last();
        $semester_subject_levels = SemesterSubjectLevel::where('semester_id', $semester->id)->select('id')->get();
        if($semester_subject_levels)
            $points = $this->model->whereIn('semester_subject_level_id', $semester_subject_levels)->orderBy('student_id')->get();
        return $points;
    }

    public function getListPoinByLevel($level_id, $teacher_id = NULL){
        $points = array();
        $semester = Semester::all()->last();

    //    dd($semester);
        if($teacher_id == NULL) {
            $semester_subject_levels = SemesterSubjectLevel::
                where('level_id', $level_id)
                ->where('semester_id', $semester->id)->select('id')->get();
        } else  {
            $semester_subject_levels = SemesterSubjectLevel::
                where('level_id', $level_id)
                ->where('teacher_id', $teacher_id)
                ->where('semester_id', $semester->id)->select('id')->get();
        }

        if($semester_subject_levels) {
            $points = $this->model->whereIn('semester_subject_level_id', $semester_subject_levels)->orderBy('student_id')->get();
        }

        return $points;
    }
}
