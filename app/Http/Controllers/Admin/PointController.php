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
use App\Repositories\SemesterSubjectLevelRepositoryInterface as SemesterSubjectLevelRepository;
use App\Repositories\PointRepositoryInterface as PointRepository;
use App\Repositories\LevelRepositoryInterface as LevelRepository;
use App\Models\Teacher;

class PointController extends Controller
{
    protected $pointRepository;
    protected $semesterSubjectLevelRepository;
    protected $userRepository;
    protected $levelRepository;
    protected $subjectRepository;
    public function __construct(

        PointRepository $pointRepository,
        SemesterSubjectLevelRepository $semesterSubjectLevelRepository,
        UserRepository $userRepository,
        LevelRepository $levelRepository,
        SubjectRepository $subjectRepository
    ) {
        $this->pointRepository = $pointRepository;
        $this->semesterSubjectLevelRepository = $semesterSubjectLevelRepository;
        $this->userRepository = $userRepository;
        $this->subjectRepository = $subjectRepository;
        $this->levelRepository = $levelRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $selectLevel = $request->selectLevel;
        $selectSubject = $request->selectSubject;
        if(\Auth()->user()->role == \App\Models\User::ROLE_ADMIN)  {
            //admin
            if($selectLevel == NULL && $selectSubject == NULL)
                $points = array();
            else
                $points = $this->pointRepository->getListPoinByLevel($selectLevel, $selectSubject);
            $levels = $this->levelRepository->all();
            $subjects = $this->subjectRepository->all();

        } else {
            //handler teacher
            $teacher = Teacher::where('user_id', \Auth()->user()->id)->first();
            if($selectLevel == NULL && $selectSubject == NULL) {
                $points = array();
            } else {
                $points = $this->pointRepository->getListPoinByLevel($selectLevel, $selectSubject, $teacher->id);
            }

            $level_ids = \App\Models\SemesterSubjectLevel::where('teacher_id', $teacher->id)->select('level_id')->get();
            $levels = \App\Models\Level::whereIn('id', $level_ids)->get();

            $subject_ids = \App\Models\SemesterSubjectLevel::where('teacher_id', $teacher->id)->select('subject_id')->get();
            $subjects = \App\Models\Subject::whereIn('id', $subject_ids)->get();
        }

        return view('admin.point.list')->with([
            'points' => $points,
            'levels'=>$levels,
            'selectSubject'=>$selectSubject,
            'subjects' => $subjects,
            'selectLevel'=>$selectLevel]);
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
        $semester_subject_groups = $this->semesterSubjectLevelRepository->selection();
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
        $semester_subject_groups = $this->semesterSubjectLevelRepository->selection();
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

    public function updatePoint(Request $request){
        $id = $request->id;
        $res = $this->pointRepository->updatePoint($id, $request->all());
        return $res;
    }


    public function calculatePoint(Request $request) {

        $calculate = $request->calculate;
        $selectLevel = $request->selectLevel;
        $selectSubject = $request->selectSubject;

        if($calculate) {
            $this->pointRepository->updateAllPoints($selectLevel, $selectSubject);
            return redirect()->back();
        }
    }

    public function exportExcel() {
        // dd("123");

        \Excel::create('export', function($excel) {
            $excel->sheet('points', function($sheet){
                $points = $this->pointRepository->all();
                $headers = $this->getColumnNames($points);
                $points_array = array_merge((array) $headers, (array) $points->toArray());
                $sheet->with($points);
            });
        })->export('xls');
    }

    public function getColumnNames($object)
    {
        $rip_headers = $object->toArray();
        $keys = array_keys($rip_headers[0]);
        foreach($keys as $value) {
            $headers[$value] = $value;
        }
        return array($headers);
        # code...
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
