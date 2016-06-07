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
        $data['semester_code'] = $data['year'].'-'.$data['semester_number'];
        $semester = $this->create($data);
        $subjects = Subject::all();
        $levels = Level::all();
        $teachers = Teacher::all();

        //prepare conduct
        $students = \App\Models\Student::all();
        foreach($students as $student)  {
            $conduct = new \App\Models\Conduct;
            $conduct->student_id = $student->id;
            $conduct->semester_id = $semester->id;
            $conduct->save();
        }
        //prepare level
        if(count($teachers) > 0) {
            foreach($levels as $level) {
                $teacher = $teachers[rand(0, count($teachers)-1)];
                $level->teacher_id = $teacher->id;
                $level->save();
            }
        }
        //prepare point
        foreach($subjects as $subject) {
            foreach($levels as $level) {
                $teachers = Teacher::where('subject_id', $subject->id)->get();
                if(count($teachers) > 0) {
                    $teacher = $teachers[rand(0, count($teachers)-1)];
                    $semester_subject_level = SemesterSubjectLevel::create([
                        'semester_id' => $semester->id,
                        'subject_id' => $subject->id,
                        'teacher_id' => $teacher->id,
                        'level_id' => $level->id]);

                    $students = Student::where('level_id', $level->id)->get();
                    foreach($students as $student) {
                        Point::create([
                            'student_id' => $student->id,
                            'semester_subject_level_id'=> $semester_subject_level->id
                        ]);
                    }
                }
            }
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
