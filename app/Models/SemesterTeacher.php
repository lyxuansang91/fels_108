<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SemesterTeacher extends Model
{
    //
    protected $table = 'semester_teachers';
    protected $fillable = ['semester_id', 'teacher_id', 'teacher_calendar'];
    public $timestamps = true;

    public function semester() {
        return $this->belongsTo(Semester::class);
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }
}
