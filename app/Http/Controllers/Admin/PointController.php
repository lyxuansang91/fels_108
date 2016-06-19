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

    public function importExcel(Request $request) {
        $is_valid = true;
        if(\Input::hasFile('excel_file')) {
            $path = \Input::file('excel_file')->getRealPath();
            $data = \Excel::load($path, function($reader) {
            })->get();

            \DB::beginTransaction();
            try {
                if(!empty($data) && $data->count()){

                    foreach ($data as $key => $value) {

                        $semester = \App\Models\Semester::where('semester_code', $value->ma_ky)->first();
                        $subject = \App\Models\Subject::where('subject_code', $value->ma_mon_hoc)->first();
                        $student = \App\Models\Student::where('student_code', $value->ma_hoc_sinh)->first();
                        $lop = explode('-', $value->ten_lop);
                        $grade_name = $lop[0];
                        $level_name = $lop[1];
                        $grade = \App\Models\Grade::where('grade_name', $grade_name)->first();
                        $level = $grade->levels()->where('level_name', $level_name)->first();
                        $semester_subject_level = \App\Models\SemesterSubjectLevel::where('semester_id', $semester->id)
                            ->where('subject_id', $subject->id)
                            ->where('level_id', $level->id)->first();

                        $point = \App\Models\Point::where('semester_subject_level_id', $semester_subject_level->id)
                            ->where('student_id', $student->id)->first();
                        $point->mark_m1 = $value->mieng_1;
                        $point->mark_m2 = $value->mieng_2;
                        $point->mark_m3 = $value->mieng_3;
                        $point->mark_m4 = $value->mieng_4;
                        $point->mark_15_1 = $value->diem_15_phut_1;
                        $point->mark_15_2 = $value->diem_15_phut_2;
                        $point->mark_15_3 = $value->diem_15_phut_3;
                        $point->mark_45_1 = $value->diem_45_phut_1;
                        $point->mark_45_2 = $value->diem_45_phut_2;
                        $point->mark_last = $value->thi;
                        if(!$point->save()) {
                            throw new \Exception("Error Processing Request", 1);
                        }
                    }
                }
                \DB::commit();

            } catch (\Exception $e) {
                \DB::rollback();
                $is_valid = false;
            }
        }
        if($is_valid)
            $request->session()->flash('success', 'Import dữ liệu thành công');
        else
            $request->session()->flash('failed', 'Import dữ liệu không thành công');
        return redirect()->back();
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
                        $new_point['Mã học sinh'] = $point->student->student_code;
                        $new_point['Tên học sinh'] = $point->student->name;
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
