<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $fillable = ['name', 'gender', 'address', 'phone', 'birthday','gender'];
    protected $table = 'students';
    public $timestamps = true;
}
