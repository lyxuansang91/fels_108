<?php

namespace App\Repositories\Eloquents;

use App\Repositories\PointRepositoryInterface;
use Exception;

class PointRepository extends Repository implements PointRepositoryInterface
{

    public $ruleAdd = [
        'semester_subject_group_id' => 'required',
        'user_id' => 'required'
    ];

    public $ruleUpdate = [
        'semester_subject_group_id' => 'required',
        'user_id' => 'required'
    ];

    public function createPoint($data)
    {
        $this->create($data);
    }

    public function updatePoint($id, $data)
    {
        $point = $this->findOrFail($id);
        $point->user_id = $data['user_id'];
        $point->semester_subject_group_id = $data['semester_subject_group_id'];
        $point->mark_m1 = $data['mark_m1'];
        $point->mark_m2 = $data['mark_m2'];
        $point->mark_m3 = $data['mark_m3'];
        $point->mark_m4 = $data['mark_m4'];
        $point->mark_15_1 = $data['mark_15_1'];
        $point->mark_15_2 = $data['mark_15_2'];
        $point->mark_15_3 = $data['mark_15_3'];
        $point->mark_45_1 = $data['mark_45_1'];
        $point->mark_45_2 = $data['mark_45_2'];
        $point->mark_last = $data['mark_last'];
        $point->save();
    }
}
