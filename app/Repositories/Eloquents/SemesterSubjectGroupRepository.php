<?php

namespace App\Repositories\Eloquents;

use App\Repositories\SemesterSubjectGroupRepositoryInterface;
use Exception;

class SemesterSubjectGroupRepository extends Repository implements SemesterSubjectGroupRepositoryInterface
{

    public $ruleAdd = [
        'semester_id' => 'required',
        'subject_id' => 'required',
        'group_id' => 'required',
        'level_id' => 'required',
        'user_id' => 'required'
    ];

    public $ruleUpdate = [
        'semester_id' => 'required',
        'subject_id' => 'required',
        'group_id' => 'required',
        'level_id' => 'required',
        'user_id' => 'required'
    ];


    public function selection()
    {
        $semester_subject_groups = $this->model->all();
        $semesterSubjectgroupArray = array();
        foreach ($semester_subject_groups as $semester_subject_group) {
            $semesterSubjectgroupArray[$semester_subject_group->id]
                = $semester_subject_group->semester->name
                .'-'. $semester_subject_group->subject->subject_name
                .'-'. $semester_subject_group->group->group_name
                .'-'. $semester_subject_group->level->level_name;
        }
        return $semesterSubjectgroupArray;
    }

    public function createSemesterSubjectGroup($data)
    {
        // $file = $data['image'];
        // $name = $file->getClientOriginalName();
        // $file->move(public_path().'/images/category', $name);
        // $data['image'] = '/images/category/' . $name;
        $this->create($data);
    }

    public function updateSemesterSubjectGroup($id, $data)
    {
        $semester_subject_group = $this->findOrFail($id);
        // if(isset($data['image'])) {
        //     $file = $data['image'];
        //     $name = $file->getClientOriginalName();
        //     $file->move(public_path().'/images/category', $name);
        //     $category->image = '/images/category/' . $name;
        // }
        // $category->name = $data['name'];
        // $category->content = $data['content'];
        $semester_subject_group->semester_id = $data['semester_id'];
        $semester_subject_group->subject_id = $data['subject_id'];
        $semester_subject_group->group_id = $data['group_id'];
        $semester_subject_group->level_id = $data['level_id'];
        $semester_subject_group->user_id = $data['user_id'];
        $semester_subject_group->save();
    }
}
