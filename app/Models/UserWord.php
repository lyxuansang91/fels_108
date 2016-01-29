<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWord extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_word';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'word_id', 'status'];

}
