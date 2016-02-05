<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\FollowRepositoryInterface as FollowRepository;
use App\Repositories\UserRepositoryInterface as UserRepository;


class FollowController extends Controller
{
    protected $followRepository;
    
    protected $userRepository;
    
    public function __construct( 
        FollowRepository $followRepository,
        UserRepository $userRepository
    ) {
        $this->followRepository = $followRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->id;
        $this->followRepository->followUser($id, auth()->id());

        return redirect()->route('user.profiles.show', $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $data = $request->search;
        $user = $this->userRepository->findOrFail($id);
        $followings = $this->followRepository->getFollowing($user, $data);
        $followeds = $this->followRepository->getFollowed($user, $data);

        return view('user.follow.showFollow')->with(['followings' => $followings, 'followeds' => $followeds, 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->followRepository->unfollowUser($id, auth()->id());

        return redirect()->route('user.profiles.show', $id);
    }
}
