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
        return $this->hasOne('App\Models\TransWord');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_word', 'word_id', 'user_id');
    }

    public function userWords()
    {
        return $this->hasMany('App\Models\UserWord');
    }
}
