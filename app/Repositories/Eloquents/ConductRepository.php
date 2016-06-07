<?php

namespace App\Repositories\Eloquents;

use App\Repositories\ConductRepositoryInterface;
use Exception;

class ConductRepository extends Repository implements ConductRepositoryInterface
{

    public $ruleAdd = [
        'conduct_name' => 'required',
        'semester_id' => 'required',
        'user_id' => 'required'
    ];

    public $ruleUpdate = [
        'conduct_name' => 'required',
        'semester_id' => 'required',
        'user_id' => 'required'
    ];

    public function createConduct($data)
    {
        $this->create($data);
    }

    public function updateConduct($id, $data)
    {
        $conduct = $this->findOrFail($id);
        $conduct->conduct_name = $data['conduct_name'] ? $data['conduct_name'] : NULL;
        return $conduct->save();
    }

    public function getListConductByLevel($semester_id, $level_id) {
        $student_ids = \App\Models\Student::where('level_id', $level_id)->select('id')->get();
        if($level_id) {
            $student_ids = \App\Models\Student::where('level_id', $level_id)->select('id')->get();
            $conducts = \App\Models\Conduct::whereIn('student_id', $student_ids)
                ->where('semester_id', $semester_id)->get();
        } else  {
            $conducts = \App\Models\Conduct::where('semester_id', $semester_id)->get();
        }

        return $conducts;
    }
}
