<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //
    protected $table = 'subjects';
    protected $fillable = ['subject_name', 'subject_code'];
    public $timestamps = true;

    public function subject_groups() {
        $this->hasMany(SubjectGroup::class);
    }
}
