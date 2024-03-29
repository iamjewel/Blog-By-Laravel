<?php

namespace App\Http\Controllers\Author;

use App\Category;
use App\Notifications\NewAuthorPost;
use App\Post;
use App\Tag;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class PostController extends Controller
{
    //Manage Post View
    public function index()
    {
        $posts = Auth::user()->posts()->latest()->paginate(5);
        return view('author.post.index', compact('posts'));
    }

    //Save Post View
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('author.post.create', compact('categories', 'tags'));
    }

    //Save Post Function
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required',

        ]);

        $image = $request->file('image');
        $slug = str_slug($request->title);

        if (isset($image)) {


            //Image Name
            $imageName = $slug . '-' . time() . '.' . $image->getClientOriginalExtension();

            //Check and Make Post Img Dir.
            if (!Storage::disk('public')->exists('post')) {
                Storage::disk('public')->makeDirectory('post');
            }

            //Resize & Upload Image For Post
            $category = Image::make($image)->resize(1600, 1066)->stream();
            Storage::disk('public')->put('post/' . $imageName, $category);

        } else {
            $imageName = 'default.png';
        }

        $post = new Post();

        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $imageName;
        $post->body = $request->body;

        if (isset($request->status)) {
            $post->status = true;
        } else {
            $post->status = false;
        }
        $post->is_approved = false;
        $post->save();

        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);

        //Send Notification To Admin
        $users = User::where('role_id', '1')->get();
        Notification::send($users, new NewAuthorPost($post));

        Toastr::success('Post Added Successfully', 'success');
        Toastr::success('Notification Sent To Admin For Approval', 'success');

        return redirect()->route('author.post.index');
    }

    //Single Post Show
    public function show(Post $post)
    {
        if ($post->user_id != Auth::id()) {
            Toastr::error('You are Not Authorized', 'Error');
            return redirect()->back();
        }
        return view('author.post.show', compact('post'));
    }

    //Edit Post View
    public function edit(Post $post)
    {
        if ($post->user_id != Auth::id()) {
            Toastr::error('You are Not Authorized', 'Error');
            return redirect()->back();
        }

        $categories = Category::all();
        $tags = Tag::all();
        return view('author.post.edit', compact('post', 'categories', 'tags'));
    }

    //Update Post Function
    public function update(Request $request, Post $post)
    {

        if ($post->user_id != Auth::id()) {
            Toastr::error('You are Not Authorized', 'Error');
            return redirect()->back();
        }

        $this->validate($request, [
            'title' => 'required',
            'image' => 'image',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required',

        ]);

        $image = $request->file('image');
        $slug = str_slug($request->title);

        if (isset($image)) {


            //Image Name
            $imageName = $slug . '-' . time() . '.' . $image->getClientOriginalExtension();

            //Check and Make Post Img Dir.
            if (!Storage::disk('public')->exists('post')) {
                Storage::disk('public')->makeDirectory('post');
            }

            //Delete Old Post Image
            if (Storage::disk('public')->exists('post/' . $post->image)) {
                Storage::disk('public')->delete('post/' . $post->image);
            }

            //Resize & Upload Image For Post
            $category = Image::make($image)->resize(1600, 1066)->stream();
            Storage::disk('public')->put('post/' . $imageName, $category);

        } else {
            $imageName = $post->image;
        }

        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $imageName;
        $post->body = $request->body;

        if (isset($request->status)) {
            $post->status = true;
        } else {
            $post->status = false;
        }
        $post->is_approved = false;
        $post->save();

        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);

        Toastr::success('Post Updated Successfully', 'success');

        return redirect()->route('author.post.index');
    }

    //Delete Post Function
    public function destroy(Post $post)
    {

        if ($post->user_id != Auth::id()) {
            Toastr::error('You are Not Authorized', 'Error');
            return redirect()->back();
        }

        //Delete Post Image
        if (Storage::disk('public')->exists('post/' . $post->image)) {
            Storage::disk('public')->delete('post/' . $post->image);
        }

        $post->categories()->detach();
        $post->tags()->detach();

        $post->delete();

        Toastr::success('Post Deleted Successfully', 'success');

        return redirect()->route('author.post.index');
    }
}
