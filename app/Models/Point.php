<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    //
    protected $fillable = ['student_level_id', 'semester_subject_level_id', 'mark_m1',
        'mark_m2', 'mark_m3', 'mark_m4', 'mark_15_1', 'mark_15_2', 'mark_15_3',
        'mark_45_1', 'mark_45_2', 'mark_last'];

    public $timestamps = true;
    protected $table = 'points';

    public function student_level() {
        return $this->belongsTo(StudentLevel::class);
    }

    public function semester_subject_level() {
        return $this->belongsTo(SemesterSubjectLevel::class);
    }
}
