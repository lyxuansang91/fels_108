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
use App\Repositories\ConductRepositoryInterface as ConductRepository;
class ReportsController extends Controller
{
    protected $pointRepository;
    protected $semesterSubjectLevelRepository;
    protected $semesterRepository;
    protected $userRepository;
    protected $levelRepository;
    protected $conductRepository;
    protected $subjectRepository;
    public function __construct(

        PointRepository $pointRepository,
        SemesterRepository $semesterRepository,
        SemesterSubjectLevelRepository $semesterSubjectLevelRepository,
        UserRepository $userRepository,
        LevelRepository $levelRepository,
        ConductRepository $conductRepository,
        SubjectRepository $subjectRepository
    ) {
        $this->pointRepository = $pointRepository;
        $this->semesterSubjectLevelRepository = $semesterSubjectLevelRepository;
        $this->semesterRepository = $semesterRepository;
        $this->userRepository = $userRepository;
        $this->subjectRepository = $subjectRepository;
        $this->levelRepository = $levelRepository;
        $this->conductRepository = $conductRepository;
    }
    public function getReport(Request $request){
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

        return view('admin.report.index')->with([
            'points' => $points,
            'levels'=>$levels,
            'selectSubject'=>$selectSubject,
            'subjects' => $subjects,
            'selectLevel'=>$selectLevel]);
    }

    public function getConduct(Request $request){
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


        return view('admin.report.conduct')->with([
            'conducts' => $conducts, 'levels' => $levels, 'selectLevel' => $selectLevel]);
    }
}
