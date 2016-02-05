<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'words';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'word'];

    const WORD_PER_PAGE = 10;
    const LEARNED = 1;
    const NOT_LEARNED = 0;
    const ALL_WORD = 2;

    public function transWord()
    {
        return $this->hasOne(TransWord::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_word', 'word_id', 'user_id');
    }

    public function userWords()
    {
        return $this->hasMany(UserWord::class);
    }

    public function lessonWords()
    {
        return $this->hasMany(LessonWord::class);
    }

    public function updateUserWordAndStatus($userWord, $status)
    {
        if($this->userWords()->count() > 0) {
            $userWord['status'] = $status;
            $this->userWords[0]->update($userWord);
        } else {
            $userWord['status'] = $status;
            UserWord::create($userWord);
        }
    }
}
