<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'grades';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['grade_name'];

    public function levels()
    {
        return $this->hasMany(Level::class);
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($grade) {
            if(count($grade->levels()) > 0)
                return false;
        });
    }
}
