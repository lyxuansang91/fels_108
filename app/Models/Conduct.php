<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conduct extends Model
{
    //
    public $timestamps = true;
    protected $fillable = ['conduct_name', 'semester_id', 'user_id'];
    protected $table = 'conducts';

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function semester() {
        return $this->belongsTo(Semester::class);
    }
}
