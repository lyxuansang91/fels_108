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
            $teachers = $this->teacherRepository->allTeacher()->paginate(10);
        else
            $teachers = $this->teacherRepository->getListTeacherBySubject($selectSubject)->paginate(10);
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

    public function exportExcel(Request $request) {
        // dd("123");
        $selectSubject = $request->selectSubject;
        \Excel::create('teachers', function($excel) use($selectSubject)  {
            $excel->sheet('teachers', function($sheet) use($selectSubject) {
                $teachers = array();
                if($selectSubject) {
                    $teacherArray = \App\Models\Teacher::where('subject_id', $selectSubject)->get();
                } else {
                    $teacherArray = \App\Models\Teacher::all();
                }
                foreach($teacherArray as $teacher) {
                    $new_teacher = array();
                    $new_teacher['Mã GV'] = $teacher->teacher_code;
                    $new_teacher['Tên GV'] = $teacher->teacher_name;
                    $new_teacher['Địa chỉ'] = $teacher->address;
                    $new_teacher['Điện thoại'] = $teacher->phone;
                    $new_teacher['Giới tính'] = $teacher->gender == 0 ? 'Nam' : 'Nữ';
                    $new_teacher['Ngày sinh'] = $teacher->birthday;
                    $new_teacher['Môn học'] = $teacher->subject->subject_code;
                    $new_teacher['Email'] = $teacher->user->email;
                    $teachers[] = $new_teacher;
                }
                // $headers = $this->getColumnNames($teachers);
                $sheet->with($teachers);
            });
        })->export('xls');

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

    public function importExcel(Request $request) {
        if(\Input::hasFile('excel_file')) {
            $path = \Input::file('excel_file')->getRealPath();
            $data = \Excel::load($path, function($reader) {
			})->get();
            \DB::beginTransaction();
            $valid = true;
            try {

                if(!empty($data) && $data->count()){
    				foreach ($data as $key => $value) {
                        $subject = \App\Models\Subject::where('subject_code', $value->mon_hoc)->first();
                        $data = [
                            'teacher_name' => $value->ten_gv,
                            'address' => $value->dia_chi,
                            'phone' => $value->dien_thoai,
                            'gender' => $value->gioi_tinh == 'Nam' ? 0 : 1,
                            'birthday'=> $value->ngay_sinh,
                            'subject_id' => $subject->id,
                            'email' => $value->email
                        ];
    					$this->teacherRepository->createTeacher($data);
    				}
    			}
                \DB::commit();

            } catch (\Exception $e) {
                \DB::rollback();
                $valid = false;
            }
        }
        if($valid) {
            $request->session()->flash('success', 'Import dữ liệu thành công');
        } else {
            $request->session()->flash('success', 'Import dữ liệu không thành công');
        }
        return redirect()->back();
    }
}
