<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\GroupRepositoryInterface as GroupRepository;
use App\Repositories\LevelRepositoryInterface as LevelRepository;
use App\Repositories\SubjectRepositoryInterface as SubjectRepository;
use App\Repositories\UserRepositoryInterface as UserRepository;
use App\Repositories\SemesterRepositoryInterface as SemesterRepository;
use App\Repositories\SemesterSubjectGroupRepositoryInterface as SemesterSubjectGroupRepository;



class SemesterSubjectGroupController extends Controller
{
    protected $semesterRepository;
    protected $subjectRepository;
    protected $groupRepository;
    protected $levelRepository;
    protected $userRepository;
    protected $semesterSubjectGroupRepository;
    public function __construct(

        SemesterRepository $semesterRepository,
        SubjectRepository $subjectRepository,
        GroupRepository $groupRepository,
        LevelRepository $levelRepository,
        UserRepository $userRepository,
        SemesterSubjectGroupRepository $semesterSubjectGroupRepository
    ) {
        $this->semesterRepository = $semesterRepository;
        $this->subjectRepository = $subjectRepository;
        $this->groupRepository = $groupRepository;
        $this->levelRepository = $levelRepository;
        $this->userRepository = $userRepository;
        $this->semesterSubjectGroupRepository = $semesterSubjectGroupRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semester_subject_groups = $this->semesterSubjectGroupRepository->all();
        return view('admin.semester_subject_group.list')->with([
            'semester_subject_groups' => $semester_subject_groups]);
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
        $semesters = $this->semesterRepository->semesterSelection();
        $subjects = $this->subjectRepository->subjectSelection();
        $groups = $this->groupRepository->groupSelection();
        $levels = $this->levelRepository->levelSelection();
        $users = $this->userRepository->userSelection();
        return view('admin.semester_subject_group.add')->with([
            'semesters' => $semesters,
            'subjects' => $subjects,
            'groups' => $groups,
            'levels' => $levels,
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
        $ruleAdd = $this->semesterSubjectGroupRepository->ruleAdd;
        $validation = \Validator::make($request->all(), $ruleAdd);
        if($validation->fails()) {
            $errors = $validation->messages();
            return redirect()->route('admin.semester_subject_groups.index')->with(['errors' => $errors]);
        }

        $this->semesterSubjectGroupRepository->createSemesterSubjectGroup($request->all());

        return redirect()->route('admin.semester_subject_groups.index');
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
        $semester_subject_group = $this->semesterSubjectGroupRepository->findOrFail($id);
        $semesters = $this->semesterRepository->semesterSelection();
        $subjects = $this->subjectRepository->subjectSelection();
        $groups = $this->groupRepository->groupSelection();
        $levels = $this->levelRepository->levelSelection();
        $users = $this->userRepository->userSelection();

        return view('admin.semester_subject_group.edit')->with([
            'semester_subject_group' => $semester_subject_group,
            'semesters' => $semesters,
            'subjects' => $subjects,
            'groups' => $groups,
            'levels' => $levels,
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
        $rule = $this->semesterSubjectGroupRepository->ruleUpdate;
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();
            return redirect()->route('admin.semester_subject_groups.edit', $id)->with(['errors' => $errors]);
        }
        $this->semesterSubjectGroupRepository->updateSemesterSubjectGroup($id, $request->all());

        return redirect()->route('admin.semester_subject_groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->semesterSubjectGroupRepository->delete($id);
        return redirect()->route('admin.semester_subject_groups.index');
    }
}
