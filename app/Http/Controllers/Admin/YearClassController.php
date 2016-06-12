<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\SemesterRepositoryInterface as SemesterRepository;
use App\Repositories\LevelRepositoryInterface as LevelRepository;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Semester;
use App\Models\Level;

class YearClassController extends Controller
{

    protected $semesterRepository;

    public function __construct(
        SemesterRepository $semesterRepository,
        LevelRepository $levelRepository)
    {
        $this->semesterRepository = $semesterRepository;
        $this->levelRepository = $levelRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $user = \Auth()->user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        if($teacher) {
            $semesters = $this->semesterRepository->all();
            $levels =  $this->levelRepository->getListLevelByTeacher($teacher->id);
            $selectLevel = $request->selectLevel;
            if($selectLevel) {

            }
        } else {

        }
        return view('admin.semester.listSemester')->with(['semesters'=>$semesters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.semester.addSemester');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rule = $this->semesterRepository->ruleAdd;
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return redirect()->route('admin.semesters.create')->with(['errors'=>$errors]);
        }
        $this->semesterRepository->createSemester($request->all());

        return redirect()->route('admin.semesters.index');
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
        $semester = $this->semesterRepository->findOrFail($id);

        return view('admin.semester.editSemester')->with(['semester'=>$semester]);
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
        $rule = [
            'semester_number' => 'required',
            'year' => 'required'
        ];
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return \Redirect::route('admin.semesters.edit', $id)->with(['errors'=>$errors]);
        }
        $this->semesterRepository->updateSemester($id, $request->all());

        return redirect()->route('admin.semesters.index');
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
        $this->semesterRepository->delete($id);

        return redirect()->route('admin.semesters.index');
    }
}
