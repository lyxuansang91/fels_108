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
}
