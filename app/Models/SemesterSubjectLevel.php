<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SemesterSubjectLevel extends Model
{
    //
    public $timestamps = true;
    protected $fillable = ['semester_id', 'subject_id', 'group_id', 'level_id', 'teacher_id'];
    protected $table = 'semester_subject_levels';

    public function semester() {
        return $this->belongsTo(Semester::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function level() {
        return $this->belongsTo(Level::class);
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    public function points() {
        return $this->hasMany(Point::class);
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($semester_subject_level) {
            $semester_subject_level->points()->delete();
        });

        static::created(function($semester_subject_level){
            $level = $semester_subject_level->level;
            $students = $level->students(); //get student in level
            \DB::beginTransaction();
            try {

                foreach($students as $student) {
                    $student_level = $student->active_student_level();
                    $point = new \App\Models\Point([
                        'student_level_id' => $student_level->id,
                        'semester_subject_level_id' => $semester_subject_level->id
                    ]);
                    if(!$point->save())
                        throw new Exception("Error Processing Request", 1);
                }
                \DB::commit();
                return true;
            } catch (\Exception $e) {
                \DB::rollback();
                return false;
            }
        });
    }
}
