<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    //
    protected $fillable = ['user_id', 'group_id'];
    protected $table = 'user_groups';
    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function group() {
        return $this->belongsTo(Group::class);
    }
}
