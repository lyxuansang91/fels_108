<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    //
    protected $table = 'semesters';
    protected $fillable = ['semester_number', 'semester_code', 'year'];
    public $timestamps = true;


    public function semester_subject_levels() {
        return $this->hasMany(SemesterSubjectLevel::class);
    }

    public function semester_points() {
        return $this->hasMany(SemesterPoint::class);
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($semester) {
            foreach($semester->semester_subject_levels as $semester_subject_level)
                $semester_subject_level->delete();
            $semester->conducts()->delete();
            $semester->semester_points()->delete();
        });

    }



    public function conducts() {
        return $this->hasMany(Conduct::class);
    }
}
