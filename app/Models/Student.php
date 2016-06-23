<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StudentLevel;

class Student extends Model
{
    //
    protected $fillable = ['name', 'gender', 'address', 'phone', 'birthday','gender', 'student_code'];
    protected $table = 'students';
    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function student_levels() {
        return $this->hasMany(StudentLevel::class);
    }

    public function conducts() {
        return $this->hasMany(Conduct::class);
    }

    public function level() {
        $student_level = $this->student_levels()->where('status', \App\Models\StudentLevel::ACTIVE)
            ->first();
        return $student_level->level;
    }

    public function active_student_level() {
        $student_level =  $this->student_levels()->where('status', \App\Models\StudentLevel::ACTIVE)->first();
        return $student_level;
    }

    public function getPointBySubjectAndSemester($subject_id, $semester_id) {
        $point = $this->active_student_level()->points()->whereRaw('semester_subject_level_id in (select id from
            semester_subject_levels where semester_subject_levels.subject_id = ? and semester_subject_levels.semester_id = ?)',
            array($subject_id, $semester_id))->select('mark_avg')->first();
        return $point;
    }

    public function semester_points() {
        return $this->hasMany(SemesterPoint::class);
    }

    public function getPointBySubjectAndYear($subject_id, $semester_year, $semester_number) {
        $point = $this->active_student_level()->points()->whereRaw('semester_subject_level_id in (select
         id from semester_subject_levels where semester_subject_levels.subject_id
         = ? and semester_subject_levels.semester_id = (select id from semesters
          where year = ? and semester_number = ?))',
         array($subject_id, $semester_year, $semester_number))->select('mark_avg')->first();
         return $point;
    }

    public function getSemesterPointBySemester($semester_year, $semester_number) {
        $semester_point = $this->active_student_level()->semester_points()->whereRaw('semester_id in (select id from
            semesters where year = ? and semester_number = ?)',
            array($semester_year, $semester_number))->first();
        return $semester_point;
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($student) {
            foreach($student->student_levels as $student_level) {
                $student_level->delete();
            }
        });
    }
}
