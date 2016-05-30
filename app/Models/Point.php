<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    //
    protected $fillable = ['user_id', 'semester_subject_group_id', 'mark_m1',
        'mark_m2', 'mark_m3', 'mark_m4', 'mark_15_1', 'mark_15_2', 'mark_15_3',
        'mark_45_1', 'mark_45_2', 'mark_last'];

    protected $table = 'points';
    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function semester_subject_group() {
        return $this->belongsTo(SemesterSubjectGroup::class);
    }
}
