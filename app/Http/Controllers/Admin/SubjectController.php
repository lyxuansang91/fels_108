<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\SubjectRepositoryInterface as SubjectRepository;
use App\Repositories\GroupRepositoryInterface as GroupRepository;

class SubjectController extends Controller
{

    protected $subjectRepository;

    protected $groupRepository;



    public function __construct(SubjectRepository $subjectRepository,
        GroupRepository $groupRepository)
    {
        $this->subjectRepository = $subjectRepository;
        $this->groupRepository = $groupRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $subjects = $this->subjectRepository->all();
        return view('admin.subject.listSubject')->with(['subjects'=>$subjects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $groupArray = $this->groupRepository->all();
        return view('admin.subject.addSubject')->with(['groupArray' => $groupArray]);
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
        $rule = $this->subjectRepository->ruleAdd;
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return redirect()->route('admin.subjects.create')->with(['errors'=>$errors]);
        }
        $this->subjectRepository->createSubject($request->all());

        return redirect()->route('admin.subjects.index');
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
        $subject = $this->subjectRepository->findOrFail($id);


        $groupArray = $this->groupRepository->all();

        return view('admin.subject.editSubject')->with(['subject'=>$subject,
            'groupArray'=> $groupArray]);
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
        $rule['subject_name'] = 'required';
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return \Redirect::route('admin.subjects.edit', $id)->with(['errors'=>$errors]);
        }
        $this->subjectRepository->updateSubject($id, $request->all());

        return redirect()->route('admin.subjects.index');
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
        $this->subjectRepository->delete($id);

        return redirect()->route('admin.subjects.index');
    }
}
