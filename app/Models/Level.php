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

    public function students() {
        return $this->hasMany(Student::class);
    }

    public function semester_subject_levels() {
        return $this->hasMany(SemesterSubjectLevel::class);
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($level) {
            $level->students()->delete();
            $level->semester_subject_levels()->delete();
        });
    }


    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
