<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {	
        $count = [
            'posts' => Post::count(),
            'users' => User::count()
        ];
        $posts = Post::latest()->take(5)->get();
        $users = User::latest()->take(5)->get();
        return view('admin.home', compact(['count', 'posts', 'users']));
    }
}
