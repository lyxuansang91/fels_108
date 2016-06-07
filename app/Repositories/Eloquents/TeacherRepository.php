<?php

namespace App\Repositories\Eloquents;

use App\Repositories\TeacherRepositoryInterface;
use App\Models\User;
use Exception;
use App\Repositories\Eloquents\UserRepository;

class TeacherRepository extends Repository implements TeacherRepositoryInterface
{

    public $ruleAdd = [
        'teacher_name' => 'required',
        'address' => 'required',
        'phone' => 'required',
        'birthday' => 'required',
        'gender' => 'required',
        'subject_id' => 'required',
        'email' => 'required|email'
    ];

    public $ruleUpdate = [
        'teacher_name' => 'required',
        'address' => 'required',
        'birthday' => 'required',
        'phone' => 'required',
        'gender' => 'required'
    ];

    public function allTeacher() {
        $users = User::where('role', User::ROLE_TEACHER)->select('id')->get();
        $teachers = $this->model->whereIn('user_id', $users)->get();
        return $teachers;
    }

    public function teacherSelection() {
        $teacherArray = array();
        $teachers = $this->model->all();
        foreach($teachers as $teacher) {
            $teacherArray[$teacher->id] = $teacher->teacher_name;
        }
        return $teacherArray;
    }

    public function createTeacher($data)
    {
        $email = $data['email'];
        $userRepository = new UserRepository(\App\Models\User::class);
        $user_by_email = $userRepository->model->where('email', $email)->first();
        if(!$user_by_email) {
            unset($data['email']);
            $user_data = ['email' => $email,
                'password' => '12345678',
                'password_confirm' => '12345678',
                'role' => User::ROLE_TEACHER];
            $user = $userRepository->create($user_data);
            if($user) {
                $data['user_id'] = $user->id;
                $this->create($data);
            }
            return true;
        }
        return false;

    }

    public function getListTeacherBySubject($subject_id){
        $users = User::where('role', User::ROLE_TEACHER)->select('id')->get();
        $teachers = $this->model->whereIn('user_id', $users)
                        ->where('subject_id', $subject_id)->get();
        return $teachers;
    }

    public function updateTeacher($id, $data)
    {
        $teacher = $this->model->findOrFail($id);
        $teacher->teacher_name = $data['teacher_name'];
        $teacher->phone = $data['phone'];
        $teacher->gender = $data['gender'];
        $teacher->address = $data['address'];
        $teacher->birthday = $data['birthday'];
        $teacher->save();
    }

    public function getListTeacherByUser($user_id) {
        $points = $this->model->where('user_id', '=', $user_id)->orderBy('created_at', 'desc')->get();
        return $points;
    }

    public function getListPoinByLevel($level_id){
        $points = array();
        $semester_subject_levels_id = SemesterSubjectLevel::where('level_id', $level_id)->first();
        if($semester_subject_levels_id)
        $points = $this->model->where('semester_subject_level_id', $semester_subject_levels_id->id)->get();
        return $points;
    }
}
