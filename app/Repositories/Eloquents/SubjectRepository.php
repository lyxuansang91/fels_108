<?php

namespace App\Repositories\Eloquents;

use App\Repositories\SubjectRepositoryInterface;
use App\Models\SubjectGroup;
use App\Models\Subject;
use Exception;

class SubjectRepository extends Repository implements SubjectRepositoryInterface
{

    public $ruleAdd = [
        'subject_name' => 'required'
    ];


    public function subjectSelection()
    {
        $subjects = $this->model->all();
        $subjectArray = array();
        foreach ($subjects as $subject) {
            $subjectArray[$subject->id] = $subject->subject_name;
        }
        return $subjectArray;
    }

    public function createSubject($data)
    {
        $group_ids = array();
        foreach($data as $key => $value) {
            $pos = strpos($key, 'group');
            if(strpos($key, 'group') === false) {

            } else {
                $group_id = intval(substr($key, $pos + 6));
                $group_ids[$group_id] = $value;
            }
        }
        $subject = $this->create($data);
        if($subject) {
            foreach($group_ids as $group_id => $val) {
                SubjectGroup::create(['subject_id'=> $subject->id, 'group_id'=> $group_id, 'factor'=> $val]);
            }
        }
    }

    public function updateSubject($id, $data)
    {
        $subject = $this->findOrFail($id);
        // if(isset($data['image'])) {
        //     $file = $data['image'];
        //     $name = $file->getClientOriginalName();
        //     $file->move(public_path().'/images/category', $name);
        //     $category->image = '/images/category/' . $name;
        // }
        // $category->name = $data['name'];
        // $category->content = $data['content'];
        $subject->subject_name = $data['subject_name'];
        $subject->save();

        $group_ids = array();
        foreach($data as $key => $value) {
            $pos = strpos($key, 'group');
            if(strpos($key, 'group') === false) {

            } else {
                $group_id = intval(substr($key, $pos + 6));
                $group_ids[$group_id] = $value;
            }
        }

        if($subject) {
            foreach($group_ids as $group_id => $val) {
                $subject_group = SubjectGroup::firstOrNew(['subject_id'=> $subject->id, 'group_id'=> $group_id]);
                $subject_group->factor = $val;
                $subject_group->save();
            }
        }
    }
}
