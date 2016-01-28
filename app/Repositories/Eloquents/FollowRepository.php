<?php

namespace App\Repositories\Eloquents;
 
use App\Repositories\FollowRepositoryInterface;
use Exception;
use App\Repositories\Eloquents\CategoryRepository;

class FollowRepository extends Repository implements FollowRepositoryInterface
{
    public function followUser($followee_id, $follower_id)
    {
        $data['followee_id'] = $followee_id;
        $data['follower_id'] = $follower_id;

        return $this->model->create($data);
    }

    public function unfollowUser($followee_id, $follower_id)
    {
        $follow = $this->model->where('followee_id', '=', $followee_id)
                    ->where('follower_id', '=', $follower_id)
                    ->delete();
    }
}