<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\TeacherRepositoryInterface as TeacherRepository;
use App\Repositories\SubjectRepositoryInterface as SubjectRepository;
use App\Repositories\UserRepositoryInterface as UserRepository;

class TeacherController extends Controller
{
    protected $teacherRepository;

    protected $subjectRepository;

    protected $userRepository;

    public function __construct(TeacherRepository $teacherRepository, SubjectRepository $subjectRepository,
    UserRepository  $userRepository)
    {
        $this->teacherRepository = $teacherRepository;
        $this->subjectRepository = $subjectRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $selectSubject = $request->subject;
        if($selectSubject == NULL)
            $teachers = $this->teacherRepository->allTeacher();
        else
            $teachers = $this->teacherRepository->getListTeacherBySubject($selectSubject);
        $subjects = $this->subjectRepository->all();

        return view('admin.teacher.listTeacher')->with(['teachers'=>$teachers, 'subjects'=> $subjects, 'selectSubject'=> $selectSubject]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjectArray = $this->subjectRepository->subjectSelection();
        return view('admin.teacher.addTeacher')->with(['subjectArray'=> $subjectArray]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = $this->teacherRepository->ruleAdd;
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return redirect()->route('admin.teachers.create')->with(['errors'=>$errors]);
        }
        $this->teacherRepository->createTeacher($request->all());

        return redirect()->route('admin.teachers.index')->withMessages('User already created');
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
        $teacher = $this->teacherRepository->findOrFail($id);
        return view('admin.teacher.editTeacher')->with(['teacher'=>$teacher]);
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
        $rule = $this->teacherRepository->ruleUpdate;
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return \Redirect::route('admin.teachers.edit', $id)->with(['errors'=>$errors]);
        }
        $this->teacherRepository->updateTeacher($id, $request->all());

        return redirect()->route('admin.teachers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->teacherRepository->delete($id);

        return redirect()->route('admin.teachers.index');
    }
}
