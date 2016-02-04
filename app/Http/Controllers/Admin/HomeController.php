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
    protected $userRepository;

    protected $wordRepository;

    protected $categoryRepository;

    public function __construct(
        UserRepository      $userRepository,
        WordRepository      $wordRepository,
        CategoryRepository  $categoryRepository
    ) {
        $this->userRepository = $userRepository;
        $this->wordRepository = $wordRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $users = $this->userRepository->all();
        $words = $this->wordRepository->all();
        $categories = $this->categoryRepository->all();

        return view('admin.home')->with(['users'=>$users, 'words'=>$words, 'categories'=>$categories]);
    }
}
