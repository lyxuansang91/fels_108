<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\SemesterRepositoryInterface as SemesterRepository;
use App\Repositories\LevelRepositoryInterface as LevelRepository;
use App\Repositories\SubjectRepositoryInterface as SubjectRepository;
use App\Repositories\GradeRepositoryInterface as GradeRepository;
use App\Repositories\TeacherRepositoryInterface as TeacherRepository;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Level;
use App\Models\Student;


class TeacherSubjectController extends Controller
{

    protected $semesterRepository;

    protected $levelRepository;

    protected $subjectRepository;

    protected $studentRepository;

    protected $gradeRepository;

    protected $teacherRepository;

    public function __construct(SemesterRepository $semesterRepository,
     LevelRepository $levelRepository, TeacherRepository $teacherRepository,
     GradeRepository $gradeRepository, SubjectRepository $subjectRepository)
    {
        $this->semesterRepository = $semesterRepository;
        $this->levelRepository = $levelRepository;
        $this->subjectRepository = $subjectRepository;
        $this->gradeRepository = $gradeRepository;
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $grades = $this->gradeRepository->all();
        $subjects = $this->subjectRepository->all();
        $teachers =  $this->teacherRepository->all();
        $semester = $this->semesterRepository->all()->last();
        $levels = $this->levelRepository->all();

        return view('admin.teacher_subject.list')->with(['semester'=>$semester,
                'levels'=> $levels,
                'teachers' => $teachers,
                'grades' => $grades,
                'semester' => $semester,
                'subjects' => $subjects]);
    }

    public function calculate(Request $request) {
        $semester_id = $request->semester_id;
        $level_id = $request->level_id;
        $teacher_subjects = $request->teacher_subjects;
        $valid = true;
        \DB::beginTransaction();
        try {
            if($teacher_subjects && count($teacher_subjects) > 0) {
                foreach($teacher_subjects as $teacher_subject) {
                    $subject_id = $teacher_subject['subject_id'];
                    $teacher_id = $teacher_subject['teacher_id'];
                    if($teacher_id) {
                        $semester_subject_level = \App\Models\SemesterSubjectLevel::firstOrNew([
                            'semester_id' => $semester_id,
                            'subject_id' => $subject_id,
                            'level_id' => $level_id,
                            'teacher_id' => $teacher_id
                        ]);
                        if(!$semester_subject_level->save())
                            throw new \Exception("Error Processing Request", 1);
                    } else {
                        throw new \Exception("Error Processing Request", 1);
                    }
                }
            }
            \DB::commit();
        } catch(\Exception $e) {
            \DB::rollback();
            $valid = false;
        }

        if($valid) {
            $request->session()->flash('success', 'Phân lịch thành công');
        } else {
            $request->session()->flash('failed', 'Phân lịch thất bại!');
        }

        return redirect()->back();
    }
}
