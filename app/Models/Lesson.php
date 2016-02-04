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
    protected $fillable = ['user_id', 'category_id', 'status'];

    const QUESTION_PER_LESSON = 20;
    const COUNT_PASSED_LESSON = 15;
    const PASSED = 1;
    const NOT_PASSED = 0;
    const PASSED_LESSON = 1;
    const NOT_PASSED_LESSON = 0;

    public function lessonWords()
    {
        return $this->hasMany(LessonWord::class);
    }

    public function isPassed()
    {
        return $this->status == self::PASSED;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function createActivity($count) {
        $activity = [
            'user_id' => auth()->id(),
            'type' => Activity::LESSON_TYPE,
            'content' => 'Did a lesson with result: ' . $count . '/' . Lesson::QUESTION_PER_LESSON . ' in ' . $this->category->name
        ];
        Activity::create($activity);    
    }
}
