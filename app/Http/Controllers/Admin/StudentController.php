<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\StudentRepositoryInterface as StudentRepository;
use App\Repositories\LevelRepositoryInterface as LevelRepository;


class StudentController extends Controller
{
    protected $studentRepository;

    protected $levelRepository;

    public function __construct(StudentRepository $studentRepository, LevelRepository $levelRepository )
    {
        $this->studentRepository = $studentRepository;
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
        if($selectLevel == NULL)
            $students = $this->studentRepository->allStudent();
        else
            $students = $this->studentRepository->getListStudentByLevel($selectLevel);
        $levels = $this->levelRepository->all();

        return view('admin.student.listStudent')->with(['students'=>$students, 'levels'=> $levels, 'selectLevel'=> $selectLevel]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levelArray = $this->levelRepository->levelSelection();
        return view('admin.student.addStudent')->with(['levelArray' => $levelArray]);
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
        $levelArray = $this->levelRepository->levelSelection();

        return view('admin.student.editStudent')->with(['student'=>$student, 'levelArray'=> $levelArray]);
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

    public function importExcel(Request $request) {
        if(\Input::hasFile('excel_file')) {
            $path = \Input::file('excel_file')->getRealPath();
            $data = \Excel::load($path, function($reader) {})->get();
            \DB::beginTransaction();
            $valid= true;
            try {
                if(!empty($data) && $data->count()){
                    foreach ($data as $key => $value) {
                        $level_id = intval($value->ma_lop);
                        $lop = explode('-', $value->ten_lop);
                        $grade_name = $lop[0];
                        $level_name = $lop[1];
                        $grade = \App\Models\Grade::where('grade_name', $grade_name)->first();
                        $level = $grade->levels()->where('level_name', $level_name)->first();
                        $student = \App\Models\Student::firstOrCreate([
                            'name' => $value->ho_ten,
                            'address' => $value->dia_chi,
                            'phone' => $value->dien_thoai,
                            'gender' => $value->gioi_tinh == 'Nam' ? 0 : 1,
                            'birthday' => $value->ngay_sinh,
                            'level_id' => $level_id
                        ]);
                    }
                }
                \DB::commit();

            } catch (\Exception $e) {
                \DB::rollback();
                $valid = false;
            }
        }
        if($valid)
            $request->session()->flash('success', 'Import dữ liệu thành công');
        else
            $request->session()->flash('failed', 'Import dữ liệu không thành công');
        return redirect()->back();
    }

    public function exportExcel(Request $request) {
        // dd("123");
        $selectLevel = $request->selectLevel;
        \Excel::create('students', function($excel) use($selectLevel)  {
            $excel->sheet('students', function($sheet) use($selectLevel) {
                $students = array();
                $semester = \App\Models\Semester::all()->last();
                if($selectLevel && $semester) {
                    $studentArray = \App\Models\Level::find($selectLevel)->students;
                } else {
                    $studentArray = \App\Models\Student::all();
                }
                foreach($studentArray as $student) {
                    $new_student = array();
                    $new_student['Mã HS'] = $student->student_code;
                    $new_student['Họ tên'] = $student->name;
                    $new_student['Giới tính'] = $student->gender == 0 ? 'Nam' : 'Nữ';
                    $new_student['Ngày sinh'] = $student->birthday;
                    $new_student['Địa chỉ'] = $student->address;
                    $new_student['Điện thoại'] = $student->phone;
                    $new_student['Tên lớp'] = $student->level->grade->grade_name.'-'.$student->level->level_name;
                    $new_student['Mã lớp'] = $student->level->id;


                    $students[] = $new_student;
                }
                // $headers = $this->getColumnNames($teachers);
                $sheet->with($students);
            });
        })->export('xls');

    }
}
