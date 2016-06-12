<?php

namespace App\Repositories\Eloquents;

use App\Repositories\StudentRepositoryInterface;
use Exception;
use \App\Models\User;
use \App\Models\Level;

class StudentRepository extends Repository implements StudentRepositoryInterface
{
    /**
     * Validate's rule for login by Admin
     * @var Array $ruleLogin
     */

    public $ruleAdd = [
        'name' => 'required',
        'gender' => 'required',
        'birthday' => 'required',
        'phone' => 'required',
    ];

    public $ruleUpdate = [
        'name' => 'required',
        'gender' => 'required',
        'birthday' => 'required',
        'phone' => 'required'
    ];

    public $ruleCreate = [

    ];

    public $rulePassword = [
    ];


    public function updateStudent($id, $data)
    {
        $student = $this->findOrFail($id);
        $student->name = $data['name'];
        $student->gender = $data['gender'];
        $student->birthday = $data['birthday'];
        $student->address = $data['address'];
        $student->phone = $data['phone'];
        $student->level_id = $data['level_id'];
        if(!$student->student_code) {
            $result = strval($student->id);
            $group = $student->level->group->group_code;
            $year = \Carbon\Carbon::parse($student->created_at)->year;
            while(strlen($result) < 3) $result = '0'.$result;
            $student->student_code = 'HS'.$year.$group.$result;
        }
        $student->save();
        return $student;
    }

    public function studentSelection() {
        $studentArray = array();
        $students = $this->model->all();
        foreach($students as $student) {
            $studentArray[$student->id] = $student->student_code;
        }
        return $studentArray;
    }

    public function findByUserId($user_id) {
        $student =  $this->model->where('user_id', $user_id)->first();
        return $student;
    }

    public function createStudent($data) {
        $student = $this->model->create($data);
        if($student) {
            //save student
            $group = $student->level->group->group_code;
            $year = \Carbon\Carbon::now()->year;
            $result = strval($student->id);
            while(strlen($result) < 3) $result = '0'.$result;
            $student->student_code = 'HS'.$year.$group.$result;
            $student->save();


            //save in point
            $semester = \App\Models\Semester::all()->last();
            if($semester) {
                $semester_subject_levels = \App\Models\SemesterSubjectLevel::where('semester_id', $semester->id)
                    ->where('level_id', $student->level_id)->get();
                foreach($semester_subject_levels as $semester_subject_level) {
                    $point = new \App\Models\Point();
                    $point->student_id = $student->id;
                    $point->semester_subject_level_id = $semester_subject_level->id;
                    $point->save();
                }

                //save in conduct
                $conduct = new \App\Models\Conduct();
                $conduct->student_id = $student->id;
                $conduct->semester_id = $semester->id;
                $conduct->save();
            }
        }
    }

    public function allStudent() {
        $students = $this->model->all();
        return $students;
    }

    public function searchListMember($data)
    {
        $users = $this->model->where('role', '=', User::ROLE_USER)
            ->where('name', 'LIKE', '%' . $data . '%')
            ->paginate(User::PER_PAGE);

        return $users;
    }

    public function getListStudentByLevel($level_id) {
        $students = $this->model->where('level_id', $level_id)->get();
        return $students;
    }
}
