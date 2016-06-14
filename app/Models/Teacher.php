<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    //
    protected $fillable = ['teacher_name', 'teacher_code', 'address','birthday', 'phone', 'gender', 'user_id', 'subject_id'];
    protected $table = 'teachers';
    public $timestamps = true;

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function semester_subject_levels() {
        return $this->hasMany(SemesterSubjectLevel::class);
    }

    public function levels() {
        return $this->hasMany(Level::class);
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($teacher) {
            $teacher->semester_subject_levels()->delete();
        });
    }


}
