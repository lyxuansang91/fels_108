<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\GradeRepositoryInterface as GradeRepository;
use App\Repositories\UserRepositoryInterface as UserRepository;
use App\Repositories\UserGradeRepositoryInterface as UserGradeRepository;

class UserGradeController extends Controller
{
    protected $userRepository;
    protected $gradeRepository;
    protected $userGradeRepository;
    public function __construct(
        UserRepository $userRepository,
        GradeRepository $gradeRepository,
        UserGradeRepository $userGradeRepository
    ) {
        $this->gradeRepository = $gradeRepository;
        $this->userRepository = $userRepository;
        $this->userGradeRepository = $userGradeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_grades = $this->userGradeRepository->all();
        return view('admin.user_grade.list')->with([
            'user_grades' => $user_grades]);
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
        $grades = $this->gradeRepository->gradeSelection();
        $users = $this->userRepository->userSelection();
        return view('admin.user_grade.add')->with([
            'grades' => $grades,
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
        $ruleAdd = $this->userGradeRepository->ruleAdd;
        $validation = \Validator::make($request->all(), $ruleAdd);
        if($validation->fails()) {
            $errors = $validation->messages();
            return redirect()->route('admin.user_grades.index')->with(['errors' => $errors]);
        }

        $this->userGradeRepository->createUserGrade($request->all());

        return redirect()->route('admin.user_grades.index');
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
        $user_grade = $this->userGradeRepository->findOrFail($id);
        $grades = $this->gradeRepository->gradeSelection();
        $users = $this->userRepository->userSelection();

        return view('admin.user_grade.edit')->with([
            'user_grade' => $user_grade,
            'grades' => $grades,
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
        $rule = $this->userGradeRepository->ruleUpdate;
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();
            return redirect()->route('admin.user_grades.edit', $id)->with(['errors' => $errors]);
        }
        $this->userGradeRepository->updateUserGrade($id, $request->all());

        return redirect()->route('admin.user_grades.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userGradeRepository->delete($id);
        return redirect()->route('admin.user_grades.index');
    }
}
