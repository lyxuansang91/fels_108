<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    //
    public $timestamps = true;
    protected $table = 'levels';
    protected $fillable = ['id', 'level_name', 'grade_id'];

    public function grade() {
        return $this->belongsTo(Grade::class);
    }
}
