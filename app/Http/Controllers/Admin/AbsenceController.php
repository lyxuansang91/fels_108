<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\AbsenceRepositoryInterface as AbsenceRepository;
use App\Repositories\SemesterRepositoryInterface as SemesterRepository;
use App\Repositories\StudentRepositoryInterface as StudentRepository;
use App\Repositories\TeacherRepositoryInterface as TeacherRepository;

class AbsenceController extends Controller
{
    protected $teacherRepository;

    protected $semesterRepository;

    protected $teacherRepository;

    protected $absenceRepository;

    public function __construct(
        AbsenceRepository $absenceRepository,
        StudentRepository $studentRepository,
        TeacherRepository $teacherRepository,
        SemesterRepository $semesterRepository
    ) {
        $this->absenceRepository = $absenceRepository;
        $this->studentRepository = $studentRepository;
        $this->teacherRepository = $teacherRepository;
        $this->semesterRepository = $semesterRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth()->user()->role == \App\Models\User::ROLE_TEACHER) {
            $teacher = $this->teacherRepository->model->where('user_id', \Auth()->user()->id)->first();
            $semester = \App\Models\Semester::all()->last();
        }
        $levels = $this->levelRepository->all();
        //$gradeArray = $this->gradeRepository->gradeSelection();
        return view('admin.level.listLevel')->with(['levels' => $levels]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $gradeArray = $this->gradeRepository->gradeSelection();
        $groupArray = $this->groupRepository->groupSelection();
        return view('admin.level.addLevel')->with(['gradeArray' => $gradeArray, 'groupArray'=> $groupArray]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $ruleAdd = $this->levelRepository->ruleAdd;
        $validation = \Validator::make($request->all(), $ruleAdd);
        if($validation->fails()) {
            $errors = $validation->messages();
            return redirect()->route('admin.levels.index')->with(['errors' => $errors]);
        }

        $this->levelRepository->createLevel($request->all());

        return redirect()->route('admin.levels.index');
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
        $level = $this->levelRepository->findOrFail($id);
        $gradeArray = $this->gradeRepository->gradeSelection();
        $groupArray = $this->groupRepository->groupSelection();

        return view('admin.level.editLevel')->with(['level' => $level, 'gradeArray' => $gradeArray, 'groupArray'=> $groupArray]);
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
        $rule = $this->levelRepository->ruleUpdate;
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return redirect()->route('admin.levels.edit', $id)->with(['errors' => $errors]);
        }
        $this->levelRepository->update($id, $request->all());

        return redirect()->route('admin.levels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->levelRepository->delete($id);

        return redirect()->route('admin.levels.index');
    }
}
