<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'follows';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['follower_id', 'followee_id'];

    public function followee()
    {
        return $this->belongsTo(User::class, 'followee_id');
    }

    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    public static function createActivity($followeeId, $follow)
    {
        $activity = [
            'user_id' => auth()->id(),
            'type' => Activity::FOLLOW_TYPE,
            'follow_id' => $follow->id,
        ];
        Activity::create($activity);
    }
}
