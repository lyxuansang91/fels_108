<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\GroupRepositoryInterface as GroupRepository;
use App\Repositories\UserRepositoryInterface as UserRepository;
use App\Repositories\UserGroupRepositoryInterface as UserGroupRepository;

class UserGroupController extends Controller
{
    protected $userRepository;
    protected $groupRepository;
    protected $userGroupRepository;
    public function __construct(
        UserRepository $userRepository,
        GroupRepository $groupRepository,
        UserGroupRepository $userGroupRepository
    ) {
        $this->groupRepository = $groupRepository;
        $this->userRepository = $userRepository;
        $this->userGroupRepository = $userGroupRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_groups = $this->userGroupRepository->all();
        return view('admin.user_group.list')->with([
            'user_groups' => $user_groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // $gradeArray = $this->gradeRepository->gradeSelection();
        $groups = $this->groupRepository->groupSelection();
        $users = $this->userRepository->userSelection();
        return view('admin.user_group.add')->with([
            'groups' => $groups,
            'users' => $users
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ruleAdd = $this->userGroupRepository->ruleAdd;
        $validation = \Validator::make($request->all(), $ruleAdd);
        if($validation->fails()) {
            $errors = $validation->messages();
            return redirect()->route('admin.user_groups.index')->with(['errors' => $errors]);
        }

        $this->userGroupRepository->createUserGroup($request->all());

        return redirect()->route('admin.user_groups.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_group = $this->userGroupRepository->findOrFail($id);
        $groups = $this->groupRepository->groupSelection();
        $users = $this->userRepository->userSelection();

        return view('admin.user_group.edit')->with([
            'user_group' => $user_group,
            'groups' => $groups,
            'users' => $users
        ]);
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
        $rule = $this->userGroupRepository->ruleUpdate;
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();
            return redirect()->route('admin.user_groups.edit', $id)->with(['errors' => $errors]);
        }
        $this->userGroupRepository->updateUserGroup($id, $request->all());

        return redirect()->route('admin.user_groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userGroupRepository->delete($id);
        return redirect()->route('admin.user_groups.index');
    }
}
