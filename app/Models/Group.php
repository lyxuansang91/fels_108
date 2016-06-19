<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    public $timestamps = true;
    protected $table = 'groups';
    protected $fillable = ['group_name', 'group_code'];

    public function levels() {
        return $this->hasMany(Level::class);
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($group) {
            if(count($group->levels()) > 0)
                return false;
        });
    }
}
