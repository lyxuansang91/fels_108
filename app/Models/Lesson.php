<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lessons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'category_id'];

    const QUESTION_PER_LESSON = 20;
    const COUNT_PASSED_LESSON = 15;
    const PASSED = 1;
    const NOT_PASSED = 0;
    const PASSED_LESSON = 1;
    const NOT_PASSED_LESSON = 0;

    public function lessonWords()
    {
        return $this->hasMany('\App\Models\LessonWord');
    }

    public function isPassed()
    {
        return $this->status == self::PASSED;
    }
}
