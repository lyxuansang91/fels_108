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
        $conduct->user_id = $data['user_id'];
        $conduct->semester_id = $data['semester_id'];
        $conduct->conduct_name = $data['conduct_name'];
        $conduct->save();
    }
}
