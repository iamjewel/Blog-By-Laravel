<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{

    //Manage Tag View
    public function index()
    {
        $tags = Tag::latest()->paginate(5);
        return view('admin.tag.index', compact('tags'));
    }


    //Add Tag View
    public function create()
    {
        return view('admin.tag.create');
    }

    //Add Tag Function
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:tags'
        ]);

        $tag = new Tag();

        $tag->name = $request->name;
        $tag->slug = str_slug($request->name);
        $tag->save();

        Toastr::success('Tag Saved Successfully', 'success');
        return redirect()->route('admin.tag.index');
    }


    public function show($id)
    {

    }


    //Edit Tag View
    public function edit($id)
    {
        $tag = Tag::find($id);

        return view('admin.tag.edit', compact('tag'));
    }

    //Update Tag Function
    public function update(Request $request, $id)
    {
        $tag = Tag::find($id);

        $this->validate($request, [
            'name' => 'required|unique:tags,name,'.$tag->id
        ]);

        $tag->name = $request->name;
        $tag->slug = str_slug($request->name);
        $tag->save();

        Toastr::success('Tag Updated Successfully', 'success');

        return redirect()->route('admin.tag.index');
    }

    //Delete Tag Function
    public function destroy($id)
    {
        Tag::find($id)->delete();

        Toastr::success('Tag Deleted Successfully', 'success');

        return redirect()->route('admin.tag.index');
    }
}
