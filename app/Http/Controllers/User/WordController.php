<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\WordRepositoryInterface as WordRepository;
use App\Repositories\CategoryRepositoryInterface as CategoryRepository;
use App\Repositories\UserRepositoryInterface as UserRepository;

class WordController extends Controller
{
    protected $wordRepository;

    protected $categoryRepository;

    public function __construct(
        WordRepository $wordRepository,
        UserRepository $userRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->wordRepository = $wordRepository;
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = session('data');
        if($request->all()) {
            $data = $request->all();
        }
        unset($data['_token']);
        $words = $this->wordRepository->getFilterWord($data, auth()->id());
        $categoryArray = $this->categoryRepository->categorySelection();
        $categoryArray[''] = 'select category';

        return view('user.word.listWord')->with(['words' => $words, 'categoryArray' => $categoryArray, 'data' => $data]);
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
        return redirect()->route('user.words.index')->with(['data' => $request->all()]); 
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