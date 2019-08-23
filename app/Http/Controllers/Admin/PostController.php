<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Notifications\AuthorPostApproval;
use App\Notifications\SubscriberNotify;
use App\Post;
use App\Subscriber;
use App\Tag;
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
        $posts = Post::latest()->paginate(5);
        return view('admin.post.index', compact('posts'));
    }

    //Add Post View
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.create', compact('categories', 'tags'));
    }

    //Add Post Function
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
        $post->is_approved = true;
        $post->save();

        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);

        //Send Notification To Admin
        $subscribers = Subscriber::all();
        foreach ($subscribers as $subscriber) {
            Notification::route('mail', $subscriber->email)->notify(new SubscriberNotify($post));
        }

        Toastr::success('Post Added Successfully', 'success');
        return redirect()->route('admin.post.index');
    }

    // Single Post Show
    public function show(Post $post)
    {
        return view('admin.post.show', compact('post'));

    }

    //Edit Post View
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.edit', compact('post', 'categories', 'tags'));
    }

    //Update Post Function
    public function update(Request $request, Post $post)
    {
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
        $post->is_approved = true;
        $post->save();

        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);

        Toastr::success('Post Updated Successfully', 'success');

        return redirect()->route('admin.post.index');
    }

    //Pending Post Show
    public function pending()
    {
        $posts = Post::where('is_approved', false)->latest()->paginate();
        return view('admin.post.pending', compact('posts'));
    }

    //Approve Pending Post Function
    public function approval($id)
    {
        $post = Post::find($id);

        if ($post->is_approved == false) {
            $post->is_approved = true;
            $post->save();

            //Send Notification To Author
            $post->user->notify(new AuthorPostApproval($post));

            //Send Notification To Subscriber
            $subscribers = Subscriber::all();
            foreach ($subscribers as $subscriber) {
                Notification::route('mail', $subscriber->email)->notify(new SubscriberNotify($post));
            }

            Toastr::success('Post Successfully Approved :)', 'Success');
        } else {

            Toastr::info('This Post is Already Approved', 'Info');
        }

        return redirect()->back();
    }


    //Delete Post Function
    public function destroy(Post $post)
    {

        //Delete Post Image
        if (Storage::disk('public')->exists('post/' . $post->image)) {
            Storage::disk('public')->delete('post/' . $post->image);
        }

        $post->categories()->detach();
        $post->tags()->detach();

        $post->delete();

        Toastr::success('Post Deleted Successfully', 'success');

        return redirect()->route('admin.post.index');
    }
}
