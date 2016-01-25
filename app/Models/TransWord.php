<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransWord extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'trans_words';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['word_id', 'trans_word'];

    public function word()
    {
        return $this->hasOne('words');
    }
}
