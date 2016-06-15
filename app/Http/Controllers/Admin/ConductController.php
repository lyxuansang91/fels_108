<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\SemesterRepositoryInterface as SemesterRepository;
use App\Repositories\UserRepositoryInterface as UserRepository;
use App\Repositories\ConductRepositoryInterface as ConductRepository;
use App\Repositories\StudentRepositoryInterface as StudentRepository;

class ConductController extends Controller
{
    protected $userRepository;
    protected $semesterRepository;
    protected $conductRepository;
    protected $studentRepository;
    public function __construct(
        SemesterRepository $semesterRepository,
        ConductRepository $conductRepository,
        StudentRepository $studentRepository
    ) {
        $this->semesterRepository = $semesterRepository;
        $this->conductRepository = $conductRepository;
        $this->studentRepository = $studentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = \Auth()->user();

        $selectLevel = $request->selectLevel;
        $semester = $this->semesterRepository->all()->last();
            if($user->role == \App\Models\User::ROLE_TEACHER) {
                $teacher = \App\Models\Teacher::where('user_id', $user->id)->first();
                $levels = \App\Models\Level::where('teacher_id', $teacher->id)->get();
                if($selectLevel && $semester)
                    $conducts = $this->conductRepository->getListConductByLevel($semester->id, $selectLevel, $teacher->id);
                else
                    $conducts = array();
            } else {
                $levels = \App\Models\Level::all();
                if($semester && $selectLevel)
                    $conducts = $this->conductRepository->getListConductByLevel($semester->id, $selectLevel, NULL);
                else
                    $conducts = array();
            }


        return view('admin.conduct.list')->with([
            'conducts' => $conducts, 'levels' => $levels, 'selectLevel' => $selectLevel]);
    }

    public function updateConduct(Request $request) {
        $id = $request->id;
        $res = $this->conductRepository->updateConduct($id, $request->all());
        return $res ? 200: 500;
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
        $semesters = $this->semesterRepository->semesterselection();
        $users = $this->userRepository->userSelection();
        return view('admin.conduct.add')->with([
            'semesters' => $semesters,
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
        $ruleAdd = $this->conductRepository->ruleAdd;
        $validation = \Validator::make($request->all(), $ruleAdd);
        if($validation->fails()) {
            $errors = $validation->messages();
            return redirect()->route('admin.conducts.index')->with(['errors' => $errors]);
        }

        $this->conductRepository->createConduct($request->all());

        return redirect()->route('admin.conducts.index');
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
        $conduct = $this->conductRepository->findOrFail($id);
        $semesters = $this->semesterRepository->semesterselection();
        $users = $this->userRepository->userSelection();

        return view('admin.conduct.edit')->with([
            'conduct' => $conduct,
            'semesters' => $semesters,
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
        $rule = $this->conductRepository->ruleUpdate;
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();
            return redirect()->route('admin.conducts.edit', $id)->with(['errors' => $errors]);
        }
        $this->conductRepository->updateConduct($id, $request->all());

        return redirect()->route('admin.conducts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->conductRepository->delete($id);
        return redirect()->route('admin.conducts.index');
    }
}
