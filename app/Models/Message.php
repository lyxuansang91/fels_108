<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //

    protected $fillable = ['student_level_id', 'text_message'];
    protected $table = 'messages';
    public $timestamps = true;
    const NOT_RECEIVED = 0;
    const RECEIVED = 1; 

    public function student_level() {
        return $this->belongsTo(StudentLevel::class);
    }
}
