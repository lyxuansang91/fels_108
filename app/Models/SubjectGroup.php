<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectGroup extends Model
{
    //
    public $timestamps = true;
    protected $fillable = ['subject_id', 'group_id', 'factor'];
    protected $table = 'subject_groups';

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function group() {
        return $this->belongsTo(Group::class);
    }
}
