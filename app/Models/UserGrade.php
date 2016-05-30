<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGrade extends Model
{
    //
    protected $fillable = ['user_id', 'grade_id'];
    protected $table = 'user_grades';
    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function grade() {
        return $this->belongsTo(Grade::class);
    }
}
