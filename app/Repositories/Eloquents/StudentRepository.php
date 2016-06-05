<?php

namespace App\Repositories\Eloquents;

use App\Repositories\StudentRepositoryInterface;
use Exception;
use \App\Models\User;

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
        $student->save();
        return $student;
    }

    public function createStudent($data)
    {
        $this->model->create($data);
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
