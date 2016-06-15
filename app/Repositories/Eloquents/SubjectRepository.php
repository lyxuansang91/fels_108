<?php

namespace App\Repositories\Eloquents;

use App\Repositories\SubjectRepositoryInterface;
use App\Models\SubjectGroup;
use App\Models\Subject;
use Exception;

class SubjectRepository extends Repository implements SubjectRepositoryInterface
{

    public $ruleAdd = [
        'subject_name' => 'required',
        'subject_code' => 'required'
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
        $subject = $this->create($data);    
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
        $subject->subject_code = $data['subject_code'];
        $subject->save();
    }
}
