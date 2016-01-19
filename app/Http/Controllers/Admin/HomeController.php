<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryInterface as UserRepository;
use App\Repositories\WordRepositoryInterface as WordRepository;
use App\Repositories\CategoryRepositoryInterface as CategoryRepository;

class HomeController extends Controller
{
    protected $userRepo;

    protected $wordRepo;

    protected $categoryRepo;

    public function __construct(
        UserRepository      $userRepo,
        WordRepository      $wordRepo,
        CategoryRepository  $categoryRepo
    ) {
        $this->userRepo = $userRepo;
        $this->wordRepo = $wordRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function index()
    {
        $users = $this->userRepo->all();
        $words = $this->wordRepo->all();
        $categories = $this->categoryRepo->all();

        return view('admin.home')->with(['users'=>$users, 'words'=>$words, 'categories'=>$categories]);
    }
}
