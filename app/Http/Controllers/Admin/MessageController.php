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
use App\Utils\MySMS;
use App\Models\Message;

class MessageController extends Controller
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
        $current_user = \Auth()->user();
        $semester = \App\Models\Semester::all()->last();
        $student_levels = array();
        if($current_user->role == User::ROLE_TEACHER) {
            $teacher = $current_user->teacher();
            if($semester) {
                $level_ids = $teacher->semester_subject_levels()
                    ->where('semester_id', $semester->id)
                    ->select('level_id')->get();
                $student_levels = \App\Models\StudentLevel::whereIn('level_id', $level_ids)
                    ->where('status', \App\Models\StudentLevel::ACTIVE)->get();
            }
        } else {
            $student_levels = \App\Models\StudentLevel::where('status', \App\Models\StudentLevel::ACTIVE)->get();
        }

        $selectStudentLevel = $request->selectStudentLevel;
        if($selectStudentLevel) {
            $messages = \App\Models\Message::where('student_level_id', $selectStudentLevel)->paginate(10);
        } else $messages = \App\Models\Message::paginate(10);
        return view('admin.message.list')->with([
            'messages' => $messages,
            'student_levels' => $student_levels,
            'selectStudentLevel' => $selectStudentLevel
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $student_level_id = $request->student_level;
        $level_id = $request->level;
        $student_level = \App\Models\StudentLevel::find($student_level_id);
        $level = \App\Models\Level::find($level_id);

        return view('admin.message.add')->with([
            'student_level' => $student_level,
            'level' => $level
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
        $ruleAdd = [
            'text_message' => 'required'
        ];
        $validation = \Validator::make($request->all(), $ruleAdd);
        if($validation->fails()) {
            $errors = $validation->messages();
            return redirect()->route('admin.messages.index')->with(['errors' => $errors]);
        }

        $student_level_id = $request->student_level_id;
        $level_id = $request->level_id;
        $text_message = $request->text_message;
        if($student_level_id) {
            $student_level = \App\Models\StudentLevel::find($student_level_id);
            if($student_level && $student_level->student->phone) {
                $result = MySMS::sendSMS($student_level->student->phone, $request->text_message);
                $message = new \App\Models\Message();
                $message->student_level_id = $student_level_id;
                $message->text_message = $text_message;
                $message->status = ($result == 100 ?  1 : 0);
                if($message->save()) {
                    $request->session()->flash('success', 'Gửi tin nhắn thành công');
                } else {
                    $request->session()->flash('failed', 'Gửi tin nhắn không thành công');
                }
            }
        } else if($level_id) {
            $level = \App\Models\Level::find($level_id);
            if($level) {
                foreach($level->active_student_levels() as $student_level) {
                    $result = MySMS::sendSMS($student_level->student->phone, $request->text_message);
                    $message = new \App\Models\Message();
                    $message->student_level_id = $student_level->id;
                    $message->text_message = $text_message;
                    $message->status = ($result == 100 ?  1 : 0);
                    if($message->save()) {
                        $request->session()->flash('success', 'Gửi tin nhắn thành công');
                    } else {
                        $request->session()->flash('failed', 'Gửi tin nhắn không thành công');
                    }
                }
            }
        } else {
            $request->session()->flash('failed', 'Vui lòng lớp hoặc chọn sinh viên');
        }

        return redirect()->route('admin.messages.index');
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

    public function exportExcel() {
        // dd("123");

        \Excel::create('export', function($excel) {
            $excel->sheet('points', function($sheet){
                $points = $this->pointRepository->all();
                $headers = $this->getColumnNames($points);
                $points_array = array_merge((array) $headers, (array) $points->toArray());
                $sheet->with($points);
            });
        })->export('xls');
    }

    public function getColumnNames($object)
    {
        $rip_headers = $object->toArray();
        $keys = array_keys($rip_headers[0]);
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
