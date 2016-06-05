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
}
