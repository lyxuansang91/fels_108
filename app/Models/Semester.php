<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    //
    protected $table = 'semesters';
    protected $fillable = ['semester_number', 'semester_code', 'year'];
    public $timestamps = true;
}
