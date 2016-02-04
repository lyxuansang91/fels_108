<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\WordRepositoryInterface as WordRepository;
use App\Repositories\CategoryRepositoryInterface as CategoryRepository;

class WordController extends Controller
{
    protected $wordRepository;

    protected $categoryRepository;

    public function __construct(
        WordRepository $wordRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->wordRepository = $wordRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $words = $this->wordRepository->getAllWord();
        $categoryArray = $this->categoryRepository->categorySelection();

        return view('admin.word.listWord')->with(['words' => $words, 'categoryArray' => $categoryArray]);
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
        if($request->submit == 'search') {

            return redirect()->route('admin.words.index')->with(['search' => $request->search, 'categoryId' => $request->category_id]); 
        }
        $rule = $this->wordRepository->ruleAddWord;
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return redirect()->route('admin.words.index')->with(['errors' => $errors]);
        }

        $this->wordRepository->addWordAndTranslate($request->all());

        return redirect()->route('admin.words.index')->with(['categoryId' => $request->category_id]);
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
        $word = $this->wordRepository->findOrFail($id);
        $categoryArray = $this->categoryRepository->categorySelection();

        return view('admin.word.editWord')->with(['word' => $word, 'categoryArray' => $categoryArray]);
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
        $rule = $this->wordRepository->ruleUpdate;
        $rule['word'] .= ',' . $id;
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return redirect()->route('admin.words.edit', $id)->with(['errors' => $errors]);
        }
        $this->wordRepository->update($id, $request->all());

        return redirect()->route('admin.words.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->wordRepository->deleteWordAndTransWord($id);

        return redirect()->route('admin.words.index');        
    }
}