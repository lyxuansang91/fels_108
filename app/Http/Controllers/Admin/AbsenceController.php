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
use App\Repositories\LevelRepositoryInterface as LevelRepository;
use App\Repositories\SubjectRepositoryInterface as SubjectRepository;

class AbsenceController extends Controller
{
    protected $studentRepository;

    protected $semesterRepository;

    protected $teacherRepository;

    protected $absenceRepository;

    protected $levelRepository;

    protected $subjectRepository;

    public function __construct(
        AbsenceRepository $absenceRepository,
        StudentRepository $studentRepository,
        TeacherRepository $teacherRepository,
        SemesterRepository $semesterRepository,
        LevelRepository $levelRepository,
        SubjectRepository $subjectRepository
    ) {
        $this->absenceRepository = $absenceRepository;
        $this->studentRepository = $studentRepository;
        $this->teacherRepository = $teacherRepository;
        $this->semesterRepository = $semesterRepository;
        $this->levelRepository = $levelRepository;
        $this->subjectRepository = $subjectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $selectLevel = $request->selectLevel;
        $semester = $this->semesterRepository->all()->last();
        if(\Auth()->user()->role == \App\Models\User::ROLE_TEACHER) {
            $teacher = \Auth()->user()->teacher();
            $level_ids = $teacher->semester_subject_levels()
                ->where('semester_id', $semester->id)->select('level_id')->get();
            $levels = \App\Models\Level::whereIn('id', $level_ids)->get();

        } else {
            $levels = $this->levelRepository->all();
        }
        if($selectLevel) {
            $absences = $this->absenceRepository->getListAbsenceByLevelAndSemester($semester->id,
                $selectLevel);
        } else {
            $absences = array();
        }

        //$gradeArray = $this->gradeRepository->gradeSelection();
        return view('admin.absence.list')->with([
            'levels' => $levels,
            'semester' => $semester,
            'selectLevel' => $selectLevel,
            'absences' => $absences]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $selectLevel = $request->selectLevel;
        $semester = $this->semesterRepository->all()->last();
        $teacher = \Auth()->user()->teacher();

        if($selectLevel) {
            $students = $this->levelRepository->findOrFail($selectLevel)
                ->students()->lists('student_code', 'id');

        } else {
            $students = array();
        }

        $subjects = array();
        if($teacher) {
            if($semester) {
                $level_ids = $teacher->semester_subject_levels()
                    ->where('semester_id', $semester->id)->select('level_id')->get();
                $levels = $this->levelRepository->whereIn('id', $level_ids)->get();
            } else $levels = array();
            $subjects[$teacher->subject->id] = $teacher->subject->subject_name;

        } else {
            $levels = $this->levelRepository->all();
            $subjects = $this->subjectRepository->all()->lists('subject_name', 'id');
        }


        return view('admin.absence.add')->with([
            'selectLevel' => $selectLevel,
            'semester' => $semester,
            'students' => $students,
            'subjects' => $subjects,
            'levels' => $levels
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

        $ruleAdd = $this->absenceRepository->ruleAdd;
        $validation = \Validator::make($request->all(), $ruleAdd);
        if($validation->fails()) {
            $errors = $validation->messages();
            return redirect()->route('admin.absences.index')->with(['errors' => $errors]);
        }

        $this->absenceRepository->createAbsence($request->all());

        return redirect()->route('admin.absences.index');
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
        $absence = $this->absenceRepository->findOrFail($id);
        $semester = $this->semesterRepository->all()->last();
        return view('admin.absence.edit')->with(['absence' => $absence, 'semester' => $semester]);
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
        $rule = $this->absenceRepository->ruleUpdate;
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return redirect()->route('admin.absences.edit', $id)->with(['errors' => $errors]);
        }
        $this->absenceRepository->update($id, $request->all());

        return redirect()->route('admin.absences.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->absenceRepository->delete($id);

        return redirect()->route('admin.absenceRepository.index');
    }
}
