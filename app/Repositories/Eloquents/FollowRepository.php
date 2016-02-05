<?php

namespace App\Repositories\Eloquents;
 
use App\Repositories\FollowRepositoryInterface;
use Exception;
use App\Repositories\Eloquents\CategoryRepository;
use App\Models\Follow;

class FollowRepository extends Repository implements FollowRepositoryInterface
{
    public function followUser($followeeId, $followerId)
    {
        $data['followee_id'] = $followeeId;
        $data['follower_id'] = $followerId;
        $this->model->create($data);
        Follow::createActivity($followeeId, 'Followed');
    }

    public function unfollowUser($followeeId, $followerId)
    {
        $follow = $this->model->where('followee_id', '=', $followeeId)
                    ->where('follower_id', '=', $followerId)
                    ->delete();
        Follow::createActivity($followeeId, 'Unfollowed');
    }

    public function getFollowing($user, $data)
    {
        $userIdArray = \App\Models\User::where('name', 'LIKE', '%' . $data . '%')->lists('id');
        $followings = $user->following()->whereIn('followee_id', $userIdArray)->get();

        return $followings;
    }

    public function getFollowed($user, $data)
    {
        $userIdArray = \App\Models\User::where('name', 'LIKE', '%' . $data . '%')->lists('id');
        $followeds = $user->follows()->whereIn('follower_id', $userIdArray)->get();

        return $followeds;
    }
}