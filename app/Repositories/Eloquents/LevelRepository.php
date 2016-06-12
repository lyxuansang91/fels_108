<?php

namespace App\Repositories\Eloquents;

use App\Repositories\LevelRepositoryInterface;
use Exception;

class LevelRepository extends Repository implements LevelRepositoryInterface
{

    public $ruleAdd = [
        'level_name' => 'required',
        'grade_id' => 'required',
        'group_id' => 'required'
    ];

    public $ruleUpdate = [
        'level_name' => 'required',
        'grade_id' => 'required',
        'group_id' => 'required'
    ];


    public function levelSelection()
    {
        $levels = $this->model->all();
        $levelArray = array();
        foreach ($levels as $level) {
            $levelArray[$level->id] = $level->grade->grade_name.'-'.$level->level_name;
        }
        return $levelArray;
    }

    public function getListLevelByTeacher($teacher_id) {
        $levels = $this->model->where('teacher_id', $teacher_id)->get();
        return $levels;
    }

    public function createLevel($data)
    {
        // $file = $data['image'];
        // $name = $file->getClientOriginalName();
        // $file->move(public_path().'/images/category', $name);
        // $data['image'] = '/images/category/' . $name;
        $level = $this->create($data);
        if($level) {
            $semester = \App\Models\Semester::all()->last();
            if($semester) {
                $subjects = \App\Models\Subject::all();
                foreach($subjects as $subject) {
                    $teachers = \App\Models\Teacher::where('subject_id', $subject->id)->get();
                    if(count($teachers) > 0) {
                        $teacher = $teachers[rand(0, count($teachers)-1)];
                        $semester_subject_level = \App\Models\SemesterSubjectLevel::create([
                            'semester_id' => $semester->id,
                            'subject_id' => $subject->id,
                            'teacher_id' => $teacher->id,
                            'level_id' => $level->id]);
                    }
                }
            }
        }
    }

    public function updateLevel($id, $data)
    {
        $level = $this->findOrFail($id);
        // if(isset($data['image'])) {
        //     $file = $data['image'];
        //     $name = $file->getClientOriginalName();
        //     $file->move(public_path().'/images/category', $name);
        //     $category->image = '/images/category/' . $name;
        // }
        // $category->name = $data['name'];
        // $category->content = $data['content'];
        $level->level_name = $data['level_name'];
        $level->grade_id = $data['grade_id'];
        $level->group_id = $data['group_id'];
        $level->save();
    }
}
