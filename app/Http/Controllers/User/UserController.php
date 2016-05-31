<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryInterface as UserRepository;
use App\Repositories\StudentRepositoryInterface as StudentRepository;
use App\Repositories\PointRepositoryInterface as PointRepository;

class UserController extends Controller
{
    protected $userRepository;
    protected $studentRepository;
    protected $pointRepository;

    public function __construct( UserRepository $userRepository,
    StudentRepository $studentRepository,
    PointRepository $pointRepository)
    {
        $this->userRepository = $userRepository;
        $this->studentRepository = $studentRepository;
        $this->pointRepository = $pointRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->userRepository->searchListMember($request->search);

        return view('user.listUser')->with(['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = $this->userRepository->ruleCreate;

        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return redirect()->route('user.profiles.create')->with(['errors' => $errors]);
        }
        $this->userRepository->registerUser($request->all());

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userRepository->findOrFail($id);
        $student = $this->studentRepository->findOrFail($user->student_id);
        $points = $this->pointRepository->getListPointByUser($id);
        $listUser = $this->userRepository->getListMember();

        return view('user.profile.showProfile')->with([
            'user' => $user,
            'listUser' => $listUser,
            'points' => $points,
            'student' => $student]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(\Auth::id() != $id) {
            return redirect()->route('user.index');
        }
        $user = $this->userRepository->findOrFail($id);

        return view('user.profile.editProfile')->with(['user' => $user]);
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
        $rule = $this->userRepository->ruleUpdate;
        $rule['email'] .= ',' . $id;
        unset($rule['role']);
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return redirect()->route('user.profiles.edit', $id)->with(['errors' => $errors]);
        }
        $data = $request->all();
        $data['role'] = User::ROLE_USER;
        $this->userRepository->updateProfile($id, $data);

        return redirect()->route('user.profiles.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
