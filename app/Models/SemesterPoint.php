<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SemesterPoint extends Model
{
    //
    protected $fillable = ['student_id', 'semester_id', 'mark'];
    protected $tables = 'semester_points';
    public $timestamps = true;

    public function semester() {
        $this->belongsTo(Semester::class);
    }

    public function student() {
        $this->belongsTo(Student::class);
    }
}
