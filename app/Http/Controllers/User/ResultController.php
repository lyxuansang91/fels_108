<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\LessonWordRepositoryInterface as LessonWordRepository;
use App\Repositories\LessonRepositoryInterface as LessonRepository;


class ResultController extends Controller
{

    protected $lessonRepo;

    protected $lessonWordRepo;
    
    public function __construct( 
        LessonWordRepository $lessonWordRepo,
        LessonRepository $lessonRepo
    ) {
        $this->lessonWordRepo = $lessonWordRepo;
        $this->lessonRepo = $lessonRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $answerArray = ['answer1', 'answer2', 'answer3', 'answer4'];
        $lesson = $this->lessonRepo->findOrFail($id);
        $result = $this->lessonWordRepo->getCorrectAnswers($id);

        return view('user.lesson.resultLesson')->with(['lesson' => $lesson, 'answerArray' => $answerArray, 'result' => $result]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
    }
}
