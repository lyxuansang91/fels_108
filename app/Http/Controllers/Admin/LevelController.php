<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\GradeRepositoryInterface as GradeRepository;
use App\Repositories\LevelRepositoryInterface as LevelRepository;

class LevelController extends Controller
{
    protected $gradeRepository;

    protected $levelRepository;

    public function __construct(
        GradeRepository $gradeRepository,
        LevelRepository $levelRepository
    ) {
        $this->gradeRepository = $gradeRepository;
        $this->levelRepository = $levelRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $levels = $this->levelRepository->all();
        $gradeArray = $this->gradeRepository->gradeSelection();

        return view('admin.level.listLevel')->with(['levels' => $levels, 'gradeArray' => $gradeArray]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $gradeArray = $this->gradeRepository->gradeSelection();
        return view('admin.level.addLevel')->with(['gradeArray' => $gradeArray]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if($request->submit == 'search') {
        //
        //     return redirect()->route('admin.words.index')->with(['search' => $request->search, 'categoryId' => $request->category_id])->withInput();
        // }
        $ruleAdd = $this->levelRepository->ruleAdd;
        $validation = \Validator::make($request->all(), $ruleAdd);
        if($validation->fails()) {
            $errors = $validation->messages();
            return redirect()->route('admin.levels.index')->with(['errors' => $errors]);
        }

        $this->levelRepository->createLevel($request->all());

        return redirect()->route('admin.levels.index')->with(['grade_id' => $request->grade_id]);
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
        $level = $this->levelRepository->findOrFail($id);
        $gradeArray = $this->gradeRepository->gradeSelection();

        return view('admin.level.editLevel')->with(['level' => $level, 'gradeArray' => $gradeArray]);
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
        $rule = $this->levelRepository->ruleUpdate;
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return redirect()->route('admin.levels.edit', $id)->with(['errors' => $errors]);
        }
        $this->levelRepository->update($id, $request->all());

        return redirect()->route('admin.levels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->levelRepository->delete($id);

        return redirect()->route('admin.levels.index');
    }
}
