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

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function points() {
        return $this->hasMany(Point::class);
    }

    public function conducts() {
        return $this->hasMany(Conduct::class);
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($student) {
            $student->points()->delete();
            $student->conducts()->delete();
        });
    }
}
