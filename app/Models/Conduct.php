<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conduct extends Model
{
    //
    public $timestamps = true;
    protected $fillable = ['conduct_name', 'semester_id', 'student_id'];
    protected $table = 'conducts';

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function semester() {
        return $this->belongsTo(Semester::class);
    }
}
