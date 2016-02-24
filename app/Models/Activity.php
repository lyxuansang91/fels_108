<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'type', 'content', 'follow_id', 'lesson_id'];

    const LESSON_TYPE = 2;
    const FOLLOW_TYPE = 1;
    const ACTIVITIES_PER_PAGE = 10;


    public function follow()
    {
        return $this->belongsTo(Follow::class, 'follow_id');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function follow()
    {
        return $this->belongsTo(Follow::class, 'follow_id');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function checkTypeLesson()
    {
        return $this->type == self::LESSON_TYPE;
    }

    public function checkTypeFollow()
    {
        return $this->type == self::FOLLOW_TYPE;
    }

    public static function getFilterActivities()
    {
        $followIdArray = Follow::where('follower_id', auth()->id())->lists('followee_id');
        $followIdArray[] = auth()->id(); 
        $dateActivities = Activity::select(\DB::raw('DATE(created_at) as day'))->whereIn('user_id', $followIdArray)->orderBy('created_at', 'desc')->get();
        foreach ($dateActivities as $activity) {
            $activities[$activity->day] = Activity::where('created_at', '>=', $activity->day . ' 00:00:00')
                ->where('created_at', '<=', $activity->day . ' 23:59:59')
                ->whereIn('user_id', $followIdArray)->get();
        }

        return $activities;
    }
}
