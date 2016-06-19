<?php

namespace App\Repositories\Eloquents;

use App\Repositories\SemesterRepositoryInterface;
use Exception;
use App\Models\User;
use App\Models\Semester;
use App\Models\SemesterSubjectLevel;
use App\Models\Conduct;
use App\Models\Point;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Level;
use App\Models\Teacher;


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

        \DB::beginTransaction();
        try {
            $data['semester_code'] = $data['year'].'-'.$data['semester_number'];
            $semester = $this->create($data);
            // $subjects = Subject::all();
            $levels = Level::all();
            $teachers = Teacher::all();
            //prepare conduct
            $students = \App\Models\Student::all();
            foreach($students as $student)  {
                $conduct = new \App\Models\Conduct;
                $conduct->student_id = $student->id;
                $conduct->semester_id = $semester->id;
                if(!$conduct->save()) {
                    throw new \Exception("Error Processing Request", 1);
                }
            }
            \DB::commit();
            return true;
        } catch(\Exception $e) {
            \DB::rollback();
            return false;
        }
    }

    public function updateSemester($id, $data)
    {
        $semester = $this->findOrFail($id);
        $semester->semester_number = $data['semester_number'];
        $semester->year = $data['year'];
        $semester->semester_code = $data['year'].'-'.$data['semester_number'];
        $semester->save();
    }
}
