<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $posts = Auth::user()->favorite_posts()->latest()->paginate(10);
        return view('admin.favorite', compact('posts'));
    }
}
