<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Repositories\LessonRepositoryInterface as LessonRepository;
use App\Repositories\LessonWordRepositoryInterface as LessonWordRepository;
use App\Repositories\CategoryRepositoryInterface as CategoryRepository;
use App\Repositories\WordRepositoryInterface as WordRepository;


class LessonController extends Controller
{

    protected $lessonRepository;
    
    protected $lessonWordRepository;
    
    protected $categoryRepository;
    
    protected $wordRepository;
    
    public function __construct( 
        LessonRepository $lessonRepository,
        LessonWordRepository $lessonWordRepository,
        CategoryRepository $categoryRepository,
        WordRepository $wordRepository
    ) {
        $this->lessonRepository = $lessonRepository;
        $this->lessonWordRepository = $lessonWordRepository;
        $this->categoryRepository = $categoryRepository;
        $this->wordRepository = $wordRepository;
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
        $category = $this->categoryRepository->findOrFail($request->category_id);
        if($category->words()->count() < Lesson::QUESTION_PER_LESSON){
            return redirect()->route('user.categories.index')->withMessages('This category not enough 20 words');
        }
        $lesson = $this->lessonRepository->create($request->all());

        return redirect()->route('user.lessons.show', $lesson->id);
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
        $lesson = $this->lessonRepository->findOrFail($id);

        return view('user.lesson.showLesson')->with(['lesson' => $lesson, 'answerArray' => $answerArray]);
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
        $lesson = $this->lessonRepository->findOrFail($id);
        $this->lessonWordRepository->updateResultLesson($request->all(), $lesson);
        
        return redirect()->route('user.results.show', $id);   
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
