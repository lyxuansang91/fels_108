<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Word;
use App\Models\Category;

class HomeController extends Controller
{

    public function index()
    {
        $users = User::getAllUser();
        $words = Word::getAllWord();
        $categories = Category::getAllCategory();

        return view('admin.home')->with(['users'=>$users, 'words'=>$words, 'categories'=>$categories]);
    }
}
