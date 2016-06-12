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

    protected static function boot() {
        parent::boot();
        static::deleting(function($semester) {
            $semester->semester_subject_levels()->delete();
        });
    }

    public function conducts() {
        return $this->hasMany(Conduct::class);
    }
}
