<?php

namespace App\Repositories\Eloquents;

use App\Repositories\UserGradeRepositoryInterface;
use Exception;

class UserGradeRepository extends Repository implements UserGradeRepositoryInterface
{

    public $ruleAdd = [
        'grade_id' => 'required',
        'user_id' => 'required'
    ];

    public $ruleUpdate = [
        'grade_id' => 'required',
        'user_id' => 'required'
    ];


    // public function levelSelection()
    // {
    //     $levels = $this->model->all();
    //     $levelArray = array();
    //     foreach ($levels as $level) {
    //         $levelArray[$level->id] = $level->level_name;
    //     }
    //     return $levelArray;
    // }

    public function createUserGrade($data)
    {
        $this->create($data);
    }

    public function updateUserGrade($id, $data)
    {
        $user_grade = $this->findOrFail($id);
        $user_grade->grade_id = $data['grade_id'];
        $user_grade->user_id = $data['user_id'];
        $user_grade->save();
    }
}
