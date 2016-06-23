<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    //
    protected $fillable = ['student_level_id', 'subject_id', 'reason', 'semester_id', 'absence_day'];
    protected $table = 'absences';
    public $timestamps = true;

    public function student_level() {
        return $this->belongsTo(StudentLevel::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function semester() {
        return $this->belongsTo(Semester::class);
    }
}
