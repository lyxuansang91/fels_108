<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\SemesterRepositoryInterface as SemesterRepository;
use App\Repositories\LevelRepositoryInterface as LevelRepository;
use App\Repositories\SubjectRepositoryInterface as SubjectRepository;
use App\Repositories\StudentRepositoryInterface as StudentRepository;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Level;
use App\Models\Student;


class SemesterClassController extends Controller
{

    protected $semesterRepository;

    protected $levelRepository;

    protected $subjectRepository;

    protected $studentRepository;

    public function __construct(SemesterRepository $semesterRepository,
    StudentRepository $studentRepository, LevelRepository $levelRepository,
    SubjectRepository $subjectRepository)
    {
        $this->semesterRepository = $semesterRepository;
        $this->levelRepository = $levelRepository;
        $this->subjectRepository = $subjectRepository;
        $this->studentRepository = $studentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $selectLevel = $request->selectLevel;
        $user = \Auth()->user();

        $teacher = Teacher::where('user_id', $user->id)->first();
        $semester = \App\Models\Semester::all()->last();
        $subjects = $this->subjectRepository->all();
        if($teacher) {
            $levels =  $this->levelRepository->getListLevelByTeacher($teacher->id);
            if($selectLevel) {
                $students = \App\Models\Level::find($selectLevel)->students()->get();
            } else {
                $students = array();
            }
        } else {
            $levels = $this->levelRepository->all();
            if($selectLevel) {
                $students = \App\Models\Level::find($selectLevel)->students()->get();
            } else {
                $students = array();
            }
        }

        return view('admin.semester_class.list')->with(['semester'=>$semester,
                'students' => $students,
                'levels'=> $levels,
                'subjects' => $subjects,
                'selectLevel' => $selectLevel]);
        // dd($subjects);

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

    public function calculate(Request $request) {

        $selectLevel = $request->selectLevel;
        $user = \Auth()->user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        $semester = \App\Models\Semester::all()->last();
        if($semester) {
            if($selectLevel) {
                $semester_subject_level_ids = \App\Models\SemesterSubjectLevel::where('level_id', $selectLevel)->select('id')->get();
                $students = \App\Models\Level::find($selectLevel)->students()->get();
            } else {
                $level_ids = \App\Models\Level::where('teacher_id', $teacher->id)->select('id')->get();
                $semester_subject_level_ids = \App\Models\SemesterSubjectLevel::whereIn('level_id', $level_ids)->select('id')->get();
                $students = \App\Models\Student::whereIn('level_id', $level_ids)->get();
            }
            $subjects = \App\Models\Subject::all();
            foreach($students as $key => $student) {
                $count = 0;
                $sum = 0;
                foreach($subjects as $subject) {
                    $point = $student->getPointBySubjectAndSemester($subject->id, $semester->id);

                    if($point->mark_avg != NULL) {
                        $sum += $point->mark_avg;
                        $count++;
                    }
                }
                if($count == count($subjects)) {
                    //tinh diem trung binh hoc ky
                    $semester_point = \App\Models\SemesterPoint::firstOrNew(
                        ['semester_id' => $semester->id, 'student_id' => $student->id]);
                    $semester_point->mark = $sum / $count;
                    $semester_point->save();
                }
            }
        } else {

        }

        return redirect()->back();
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
