<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    public $timestamps = true;
    protected $table = 'groups';
    protected $fillable = ['group_name'];
    const NANGCAO_KHTN_FACTOR = 2;
    const NANGCAO_XH_FACTOR = 2;
    const BASIC_FACTOR = 1;
}
