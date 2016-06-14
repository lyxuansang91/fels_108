<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $fillable = ['name', 'gender', 'address', 'phone', 'birthday','gender', 'level_id', 'student_code'];
    protected $table = 'students';
    public $timestamps = true;

    public function level() {
        return $this->belongsTo(Level::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function points() {
        return $this->hasMany(Point::class);
    }

    public function conducts() {
        return $this->hasMany(Conduct::class);
    }

    public function getPointBySubjectAndSemester($subject_id, $semester_id) {
        $point = $this->points()->whereRaw('semester_subject_level_id in (select id from
            semester_subject_levels where semester_subject_levels.subject_id = ? and semester_subject_levels.semester_id = ?)',
            array($subject_id, $semester_id))->select('mark_avg')->first();
        return $point;
    }

    public function semester_points() {
        return $this->hasMany(SemesterPoint::class);
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($student) {
            $student->points()->delete();
            $student->conducts()->delete();
            $student->semester_points()->delete();
        });
    }
}
