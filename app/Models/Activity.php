<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'type', 'content', 'follow_id', 'lesson_id'];

    const LESSON_TYPE = 2;
    const FOLLOW_TYPE = 1;

    public function checkTypeLesson()
    {
        return $this->type == self::LESSON_TYPE;
    }

    public function checkTypeFollow()
    {
        return $this->type == self::FOLLOW_TYPE;
    }
}
