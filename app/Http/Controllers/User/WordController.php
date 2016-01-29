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
    protected $wordRepo;

    protected $categoryRepo;

    public function __construct(
        WordRepository $wordRepo,
        UserRepository $userRepo,
        CategoryRepository $categoryRepo
    ) {
        $this->wordRepo = $wordRepo;
        $this->userRepo = $userRepo;
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = session('data');
        $words = $this->wordRepo->getFilterWord($data);
        $categoryArray = $this->categoryRepo->categorySelection();
        $categoryArray[''] = 'select category';

        return view('user.word.listWord')->with(['words' => $words, 'categoryArray' => $categoryArray]);
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

        return redirect()->route('user.words.index')->with(['data' => $request->all(), 'categoryId' => $request->category_id]); 
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