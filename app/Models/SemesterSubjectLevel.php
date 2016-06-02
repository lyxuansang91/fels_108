<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SemesterSubjectLevel extends Model
{
    //
    public $timestamps = true;
    protected $fillable = ['semester_id', 'subject_id', 'group_id', 'level_id', 'student_id'];
    protected $table = 'semester_subject_levels';

    public function semester() {
        return $this->belongsTo(Semester::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function level() {
        return $this->belongsTo(Level::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }
}
