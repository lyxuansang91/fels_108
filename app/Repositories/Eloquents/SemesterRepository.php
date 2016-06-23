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
use App\Models\StudentLevel;


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
            if(!$semester)
                throw new Exception("Error Processing Request", 1);


            if($semester->semester_number == 1) {
                //prepare student_level with status finished
                $finished_student_levels = \App\Models\StudentLevel::where(
                    'status', \App\Models\StudentLevel::FINISH)->get();
                foreach($finished_student_levels as $student_level) {
                    //
                    $student = $student_level->student;
                    $student->delete();
                }

                $in_progress_student_levels = \App\Models\StudentLevel::where('status', \App\Models\StudentLevel::IN_PROGRESS)->get();
                foreach($in_progress_student_levels as $student_level) {
                    $level_id = $student_level->level_id;
                    $student_id = $student_level->student_id;
                    $active_student_level = StudentLevel::where('level_id', $level_id)
                        ->where('student_id', $student_id)
                        ->where('status', StudentLevel::ACTIVE);
                    $active_student_level->status = StudentLevel::INACTIVE;
                    $active_student_level->save();
                    $student_level->status = \App\Models\StudentLevel::ACTIVE;
                    $student_level->save();
                }
            }

            // $subjects = Subject::all();
            $levels = Level::all();
            $teachers = Teacher::all();
            //prepare conduct
            $students = \App\Models\Student::all();

            foreach($students as $student)  {
                $student_level = $student->active_student_level();
                $conduct = new \App\Models\Conduct();
                $conduct->student_level_id = $student_level->id;
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
