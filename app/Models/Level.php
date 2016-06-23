<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    //
    public $timestamps = true;
    protected $table = 'levels';
    protected $fillable = ['id', 'level_name', 'grade_id', 'group_id', 'teacher_id'];

    public function grade() {
        return $this->belongsTo(Grade::class);
    }

    public function student_levels() {
        return $this->hasMany(StudentLevel::class);
    }

    public function students() {
        $student_ids = $this->student_levels()->where('status',
            \App\Models\StudentLevel::ACTIVE)->select('student_id')->get();
        $students = \App\Models\Student::whereIn('id', $student_ids)->get();
        return $students;
    }

    public function active_student_levels() {
        $student_levels = $this->student_levels()->where('status', \App\Models\StudentLevel::ACTIVE)->get();
        return $student_levels;
    }

    public function semester_subject_levels() {
        return $this->hasMany(SemesterSubjectLevel::class);
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($level) {
            // $level->semester_subject_levels()->delete();
        });
    }


    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
