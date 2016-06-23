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
        \DB::beginTransaction();
        try {
            $student = $this->model->create($data);
            if($student) {
                //save student
                $level_id = $data['level_id'];
                $level = \App\Models\Level::findOrFail($level_id);
                $group = $level->group->group_code;
                $year = \Carbon\Carbon::now()->year;
                $result = strval($student->id);
                while(strlen($result) < 3) $result = '0'.$result;
                $student->student_code = 'HS'.$year.$group.$result;
                $student->save();

                //save student_levels
                $student_level = $student->student_levels()->create([
                    'level_id' => $level_id,
                    'status' => \App\Models\StudentLevel::ACTIVE
                ]);

                if(!$student_level)
                    throw new Exception("Error Processing Request", 1);

                $semester = \App\Models\Semester::all()->last();
                if($semester && $student_level) {
                    //save in conduct
                    $conduct = new \App\Models\Conduct();
                    $conduct->student_level_id = $student_level->id;
                    $conduct->semester_id = $semester->id;
                    $conduct->save();

                    $subjects = \App\Models\Subject::all();
                    //save in point
                    foreach($subjects as $subject) {
                        $semester_subject_level = $semester->semester_subject_levels()
                            ->where('level_id', $level->id)
                            ->where('subject_id', $subject->id)
                            ->where('semester_id', $semester->id)->first();
                        if($semester_subject_level) {
                            $point = $semester_subject_level->points()->create([
                                'student_level_id' => $student_level->id
                            ]);
                            if(!$point)
                                throw new Exception("Error Processing Request", 1);
                        }
                    }
                }
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
        }
    }

    public function allStudent() {
        $students = $this->model->paginate(10);
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
        $students = $this->model->where('level_id', $level_id)->paginate(10);
        return $students;
    }
}
