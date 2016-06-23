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

        $teacher = $user->teacher();
        $semester = \App\Models\Semester::all()->last();
        $subjects = $this->subjectRepository->all();
        if($teacher) {
            $levels =  $this->levelRepository->getListLevelByTeacher($teacher->id);
            if($selectLevel) {
                $students = \App\Models\Level::find($selectLevel)->students();
            } else {
                $students = array();
            }
        } else {
            $levels = $this->levelRepository->all();
            if($selectLevel) {
                $students = \App\Models\Level::find($selectLevel)->students();
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


    public function calculate(Request $request) {

        $selectLevel = $request->selectLevel;
        $user = \Auth()->user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        $semester = \App\Models\Semester::all()->last();
        if($semester) {
            if($selectLevel) {
                $semester_subject_level_ids = \App\Models\SemesterSubjectLevel::where('level_id', $selectLevel)->select('id')->get();
                $students = \App\Models\Level::find($selectLevel)->students();
            } else {
                $level_ids = \App\Models\Level::where('teacher_id', $teacher->id)->select('id')->get();
                $semester_subject_level_ids = \App\Models\SemesterSubjectLevel::whereIn('level_id', $level_ids)->select('id')->get();
                $students = \App\Models\Student::whereIn('level_id', $level_ids)->get();
            }
            $subjects = \App\Models\Subject::all();
            foreach($students as $key => $student) {
                $count = 0;
                $sum = 0;
                $min_point = 11;
                foreach($subjects as $subject) {
                    $point = $student->getPointBySubjectAndSemester($subject->id, $semester->id);
                    if($point->mark_avg != NULL) {
                        if($min_point > $point->mark_avg) $min_point = $point->mark_avg;
                        $sum += $point->mark_avg;
                        $count++;
                    }
                }
                if($count == count($subjects)) {
                    //tinh diem trung binh hoc ky
                    $semester_point = \App\Models\SemesterPoint::firstOrNew(
                        ['semester_id' => $semester->id, 'student_level_id' => $student->active_student_level()->id]);
                    $mark = $sum / $count;
                    $semester_point->mark = $sum / $count;
                    if($mark >= 8.0 && $min_point >= 6.5)
                        $semester_point->evaluate = 'Giỏi';
                    else if($mark >= 6.5 && $min_point >= 5.0)
                        $semester_point->evaluate = 'Khá';
                    else if($mark >= 5.0 && $min_point >= 3.5)
                        $semester_point->evaluate = 'Trung bình';
                    else if($mark >= 3.5 && $min_point >= 2.0)
                        $semester_point->evaluate = 'Yếu';
                    else
                        $semester_point->evaluate = 'Kém';

                    //xet hoc luc
                    $semester_point->save();
                }
            }
        } else {

        }

        return redirect()->back();
    }
}
