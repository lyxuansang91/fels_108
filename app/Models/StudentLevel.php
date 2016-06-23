<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentLevel extends Model
{
    //
    const INACTIVE = 0;
    const ACTIVE = 1;
    const IN_PROGRESS = 2;
    const FINISH = 3; 

    protected $fillable = ['student_id', 'level_id', 'status'];
    protected $table = 'student_levels';
    public $timestamps = true;

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function level() {
        return $this->belongsTo(Level::class);
    }

    public function points() {
        return $this->hasMany(Point::class);
    }

    public function conducts() {
        return $this->hasMany(Conduct::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }

    public function absences() {
        return $this->hasMany(Absence::class);
    }

    public function semester_points() {
        return $this->hasMany(SemesterPoint::class);
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($student_level) {
            $student_level->points()->delete();
            $student_level->conducts()->delete();
            $student_level->absences()->delete();
            $student_level->semester_points()->delete();
            $student_level->messages()->delete();
        });
    }
}
