<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //

    protected $fillable = ['student_id', 'text_message'];
    protected $table = 'messages';
    public $timestamps = true;

    public function student() {
        return $this->belongsTo(Student::class);
    }
}
