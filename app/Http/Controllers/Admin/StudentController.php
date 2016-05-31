<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\StudentRepositoryInterface as StudentRepository;


class StudentController extends Controller
{
    protected $studentRepository;

    public function __construct(StudentRepository $studentRepository )
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = $this->studentRepository->all();

        return view('admin.student.listStudent')->with(['students'=>$students]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.student.addStudent');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = $this->studentRepository->ruleAdd;
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return redirect()->route('admin.students.create')->with(['errors'=>$errors]);
        }
        $this->studentRepository->createStudent($request->all());

        return redirect()->route('admin.students.index')->withMessages('User already created');
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
        $student = $this->studentRepository->findOrFail($id);

        return view('admin.student.editStudent')->with(['student'=>$student]);
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
        $rule = $this->studentRepository->ruleUpdate;
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return \Redirect::route('admin.students.edit', $id)->with(['errors'=>$errors]);
        }
        $this->studentRepository->updateStudent($id, $request->all());

        return redirect()->route('admin.students.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->studentRepository->delete($id);

        return redirect()->route('admin.students.index');
    }
}
