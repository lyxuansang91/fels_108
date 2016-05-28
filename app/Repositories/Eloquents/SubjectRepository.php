<?php

namespace App\Repositories\Eloquents;

use App\Repositories\SubjectRepositoryInterface;
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
        // $file = $data['image'];
        // $name = $file->getClientOriginalName();
        // $file->move(public_path().'/images/category', $name);
        // $data['image'] = '/images/category/' . $name;
        $this->create($data);
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
    }
}
