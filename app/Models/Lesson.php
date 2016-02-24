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
    const LESSON_PER_PAGE = 10;

    public function lessonWords()
    {
        return $this->hasMany(LessonWord::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPassed()
    {
        return $this->status == self::PASSED;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function createActivity($lesson) 
    {
        $activity = [
            'user_id' => auth()->id(),
            'type' => Activity::LESSON_TYPE,
            'lesson_id' => $lesson->id,
        ];
        Activity::create($activity);    
    }

    public function countPassed()
    {
        return $this->lessonWords()->where('lesson_word.result', '=', 1)->get();
    }
}
