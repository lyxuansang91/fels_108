<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonWord extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lesson_word';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['word_id', 'category_id', 'lesson_id', 'result', 'answer1', 'answer2', 'answer3', 'answer4', 'choosed'];

    const CORRECT_ANSWER = 1;
    const INCORRECT_ANSWER = 0;

    public function word()
    {
        return $this->belongsTo(Word::class);
    }

    public function isCorrectAnswer()
    {
        return $this->result == self::CORRECT_ANSWER;
    }
}
