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

class FeeController extends Controller
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


        return view('admin.fee.list')->with([
            'data' => array()
        ]);
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

    public function importExcel(Request $request) {
        $is_valid = true;
        if(\Input::hasFile('excel_file')) {
            $path = \Input::file('excel_file')->getRealPath();
            $data = \Excel::load($path, function($reader) {
            })->get();
        }

        // if($is_valid)
        //     $request->session()->flash('success', 'Import dữ liệu thành công');
        // else
        //     $request->session()->flash('failed', 'Import dữ liệu không thành công');
        return view('admin.fee.list')->with([
            'data' => $data
        ]);
    }

    public function exportExcel(Request $request) {
        // dd("123");
        $selectLevel = $request->selectLevel;
        $selectSubject = $request->selectSubject;
        $semester = \App\Models\Semester::all()->last();
        if($selectLevel && $selectSubject && $semester) {
            \Excel::create('point', function($excel) use($semester, $selectLevel, $selectSubject)  {
                $excel->sheet('points', function($sheet) use($semester, $selectLevel, $selectSubject) {
                    $points = array();

                    $semester_subject_level = \App\Models\SemesterSubjectLevel::where('semester_id', $semester->id)
                        ->where('subject_id', $selectSubject)
                        ->where('level_id', $selectLevel)->first();

                    $pointArray = $semester_subject_level->points;
                    foreach($pointArray as $point) {
                        $new_point = array();
                        $new_point['Mã kỳ'] = $point->semester_subject_level->semester->semester_code;
                        $new_point['Mã lớp'] = $point->semester_subject_level->level_id;
                        $new_point['Tên lớp'] = $point->semester_subject_level->level->grade->grade_name .'-'. $point->semester_subject_level->level->level_name;
                        $new_point['Mã môn học'] = $point->semester_subject_level->subject->subject_code;
                        $new_point['Mã học sinh'] = $point->student_level->student->student_code;
                        $new_point['Tên học sinh'] = $point->student_level->student->name;
                        $new_point['Miệng 1'] = $point->mark_m1;
                        $new_point['Miệng 2'] = $point->mark_m2;
                        $new_point['Miệng 3'] = $point->mark_m3;
                        $new_point['Miệng 4'] = $point->mark_m4;
                        $new_point['Điểm 15 phút 1'] = $point->mark_15_1;
                        $new_point['Điểm 15 phút 2'] = $point->mark_15_2;
                        $new_point['Điểm 15 phút 3'] = $point->mark_15_3;
                        $new_point['Điểm 45 phút 1'] = $point->mark_45_1;
                        $new_point['Điểm 45 phút 2'] = $point->mark_45_2;
                        $new_point['Thi'] = $point->mark_last;
                        $new_point['Trung bình'] = $point->mark_avg;

                        $points[] = $new_point;
                    }
                    $headers = $this->getColumnNames($points);
                    $points_array = array_merge((array) $headers, (array) $points);
                    $sheet->with($points);
                });
            })->export('xls');
        }
    }

    public function getColumnNames($object)
    {
        $keys = array_keys($object[0]);
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
