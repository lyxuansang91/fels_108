<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conduct extends Model
{
    //
    public $timestamps = true;
    protected $fillable = ['conduct_name', 'semester_id', 'student_level_id'];
    protected $table = 'conducts';

    public function student_level() {
        return $this->belongsTo(StudentLevel::class);
    }

    public function semester() {
        return $this->belongsTo(Semester::class);
    }

    const TOT = 1;
    const KHA = 2;
    const TRUNGBINH = 3;
    const YEU = 4;
}
