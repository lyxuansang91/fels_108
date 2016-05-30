<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\GroupRepositoryInterface as GroupRepository;

use App\Repositories\SubjectRepositoryInterface as SubjectRepository;
use App\Repositories\UserRepositoryInterface as UserRepository;
use App\Repositories\SemesterRepositoryInterface as SemesterRepository;
use App\Repositories\SemesterSubjectGroupRepositoryInterface as SemesterSubjectGroupRepository;
use App\Repositories\PointRepositoryInterface as PointRepository;

class PointController extends Controller
{
    protected $pointRepository;
    protected $semesterSubjectGroupRepository;
    protected $userRepository;
    public function __construct(

        PointRepository $pointRepository,
        SemesterSubjectGroupRepository $semesterSubjectGroupRepository,
        UserRepository $userRepository
    ) {
        $this->pointRepository = $pointRepository;
        $this->semesterSubjectGroupRepository = $semesterSubjectGroupRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $points = $this->pointRepository->all();
        return view('admin.point.list')->with([
            'points' => $points]);
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
        $semester_subject_groups = $this->semesterSubjectGroupRepository->selection();
        $users = $this->userRepository->userSelection();
        return view('admin.point.add')->with([
            'semester_subject_groups' => $semester_subject_groups,
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
        $ruleAdd = $this->pointRepository->ruleAdd;
        $validation = \Validator::make($request->all(), $ruleAdd);
        if($validation->fails()) {
            $errors = $validation->messages();
            return redirect()->route('admin.points.index')->with(['errors' => $errors]);
        }

        $this->pointRepository->createPoint($request->all());

        return redirect()->route('admin.points.index');
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
        $point = $this->pointRepository->findOrFail($id);
        $semester_subject_groups = $this->semesterSubjectGroupRepository->selection();
        $users = $this->userRepository->userSelection();

        return view('admin.point.edit')->with([
            'point' => $point,
            'semester_subject_groups' => $semester_subject_groups,
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
        $rule = $this->pointRepository->ruleUpdate;
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();
            return redirect()->route('admin.points.edit', $id)->with(['errors' => $errors]);
        }
        $this->pointRepository->updatePoint($id, $request->all());

        return redirect()->route('admin.points.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->pointRepository->delete($id);
        return redirect()->route('admin.points.index');
    }
}
