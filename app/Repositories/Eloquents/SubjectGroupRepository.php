<?php

namespace App\Repositories\Eloquents;

use App\Repositories\SubjectGroupRepositoryInterface;
use Exception;

class SubjectGroupRepository extends Repository implements SubjectGroupRepositoryInterface
{
    public function bySubject($subject_id) {
        $subject_groups = $this->model->where(['subject_id'=> $subject_id])->get();
        return $subject_groups;
    }

}
