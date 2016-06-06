<?php

namespace App\Repositories\Eloquents;

use App\Repositories\PointRepositoryInterface;
use App\Models\SemesterSubjectLevel;
use App\Models\Semester;
use App\Models\Teacher;
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

    public function getListPointByStudent($student_id) {
        $points = $this->model->where('student_id', '=', $student_id)->orderBy('created_at', 'desc')->get();
        return $points;
    }

    public function updateAllPoints($level_id, $subject_id) {

        $current_user = \Auth()->user();

        $teacher = Teacher::where('user_id', $current_user->id)->first();

        if($current_user->role == \App\Models\User::ROLE_TEACHER)  {
            if($level_id && $subject_id) {
                $semester_subject_levels = \App\Models\SemesterSubjectLevel::where('teacher_id', $teacher->id)
                ->where('subject_id', $subject_id)
                ->where('level_id', $level_id)
                ->select('id')->get();
            } else {
                $semester_subject_levels = \App\Models\SemesterSubjectLevel::where('teacher_id', $teacher->id)
                    ->select('id')->get();
            }
            $points = $this->model->whereIn('semester_subject_level_id', $semester_subject_levels)->get();
        } else {
            if($level_id && $subject_id) {
                $semester_subject_levels = \App\Models\SemesterSubjectLevel::where('subject_id', $subject_id)
                    ->where('level_id', $level_id)
                    ->select('id')->get();
                $points = $this->model->whereIn('semester_subject_level_id', $semester_subject_levels)->get();
            } else  {
                $points = $this->model->all();
            }

        }

        foreach($points as $point) {
            $count_m = 0;
            $count_15 = 0;
            $count_45 = 0;
            $count_last = 0;
            $sum = 0;
            if($point->mark_m1) {
                $sum += $point->mark_m1;
                $count_m++;
            }
            if($point->mark_m2) {
                $sum += $point->mark_m2;
                $count_m++;
            }

            if($point->mark_m3) {
                $sum += $point->mark_m3;
                $count_m++;
            }

            if($point->mark_m4) {
                $sum += $point->mark_m4;
                $count_m++;
            }
            if($point->mark_15_1) {
                $sum += $point->mark_15_1;
                $count_15++;
            }

            if($point->mark_15_2) {
                $sum += $point->mark_15_2;
                $count_15++;
            }

            if($point->mark_15_3) {
                $sum += $point->mark_15_3;
                $count_15++;
            }
            if($point->mark_45_1) {
                $sum += ($point->mark_45_1 * 2);
                $count_45++;
            }

            if($point->mark_45_2) {
                $sum += ($point->mark_45_2 * 2);
                $count_45++;
            }

            if($point->mark_last) {
                $sum += ($point->mark_last * 3);
                $count_last++;
            }
            if($count_m > 0 && $count_15 > 0 && $count_45 > 0 && $count_last > 0) {
                $point->mark_avg = $sum / ($count_m + $count_15 + $count_45 * 2 + $count_last * 3);
            } else $point->mark_avg = NULL;
            $point->save();
        }
    }


    public function getAllPoint($teacher_id = NULL) {
        $points = array();
        $semester = Semester::all()->last();
        if(!$teacher_id)  {
            $semester_subject_levels = SemesterSubjectLevel::where('semester_id', $semester->id)->select('id')->get();
        } else {
            $semester_subject_levels = SemesterSubjectLevel::where('semester_id', $semester->id)
                                ->where('teacher_id', $teacher_id)
                                ->select('id')->get();
        }
        if($semester_subject_levels)
            $points = $this->model->whereIn('semester_subject_level_id', $semester_subject_levels)->orderBy('student_id')->get();
        return $points;
    }

    public function getListPoinByLevel($level_id, $subject_id, $teacher_id = NULL){
        $points = array();
        $semester = Semester::all()->last();

    //    dd($semester);
        if($teacher_id == NULL) {
            $semester_subject_levels = SemesterSubjectLevel::
                where('level_id', $level_id)
                ->where('semester_id', $semester->id)
                ->where('subject_id', $subject_id)->select('id')->get();
        } else  {
            $semester_subject_levels = SemesterSubjectLevel::
                where('level_id', $level_id)
                ->where('teacher_id', $teacher_id)
                ->where('subject_id', $subject_id)
                ->where('semester_id', $semester->id)->select('id')->get();
        }

        if($semester_subject_levels) {
            $points = $this->model->whereIn('semester_subject_level_id', $semester_subject_levels)->orderBy('student_id')->get();
        }

        return $points;
    }
}
