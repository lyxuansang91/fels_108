<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepositoryInterface as UserRepository;
use App\Repositories\WordRepositoryInterface as WordRepository;
use App\Repositories\CategoryRepositoryInterface as CategoryRepository;

class WordController extends Controller
{
    protected $userRepo;

    protected $wordRepo;

    protected $categoryRepo;

    public function __construct(
        UserRepository $userRepo,
        WordRepository $wordRepo,
        CategoryRepository $categoryRepo
    ) {
        $this->userRepo = $userRepo;
        $this->wordRepo = $wordRepo;
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $words = $this->wordRepo->all();
        $cateArray = $this->categoryRepo->categorySelection();

        return view('admin.word.listWord')->with(['words'=>$words, 'cateArray'=>$cateArray]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cateArray = $this->categoryRepo->categorySelection();

        return view('admin.word.addWord')->with(['cateArray'=>$cateArray]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->category_id);
        $rule = $this->wordRepo->ruleAddWord;
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return redirect()->route('admin.words.index')->with(['errors'=>$errors]);
        }

        $this->wordRepo->addWordAndTranslate($request->all());


        return redirect()->route('admin.words.index')->with(['categoryId'=>$request->category_id]);
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
        dd(\Input::all());
        $rule = $this->userRepo->ruleUpdate;
        $rule['email'] .= ',' . $id;
        $validation = \Validator::make($request->all(), $rule);
        if($validation->fails()) {
            $errors = $validation->messages();

            return \Redirect::route('admin.members.edit', $id)->with(['errors'=>$errors]);
        }
        $this->userRepo->updateProfile($id, $request->all());

        return redirect()->route('admin.members.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}