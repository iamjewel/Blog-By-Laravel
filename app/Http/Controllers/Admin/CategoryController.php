<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    //Manage Category View
    public function index()
    {
        $categories = Category::latest()->paginate(5);
        return view('admin.category.index', compact('categories'));
    }

    //Add Category View
    public function create()
    {
        return view('admin.category.create');
    }


    //Add Category Function
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories',
            'image' => 'required|mimes:jpeg,png,jpg'
        ]);


        $image = $request->file('image');
        $slug = str_slug($request->name);

        if (isset($image)) {

            //Check and Make Category Img Dir.
            if (!Storage::disk('public')->exists('category')) {
                Storage::disk('public')->makeDirectory('category');
            }
            //Image Name
            $imageName = $slug . '-' . time() . '.' . $image->getClientOriginalExtension();

            //Image Url
            $directory = 'storage/category/';
            $imageUrl = $directory . $imageName;

            //Image Upload For Category
            Image::make($image)->resize(1600, 479)->save($imageUrl);


            //Check Category Slider Img Dir.
            if (!Storage::disk('public')->exists('category/slider')) {
                Storage::disk('public')->makeDirectory('category/slider');
            }

            //Image Url
            $directory = 'storage/category/slider/';
            $imageUrl = $directory . $imageName;

            //Image Upload For Category Slider
            Image::make($image)->resize(500, 333)->save($imageUrl);

        } else {
            $imageUrl = 'storage/category/default.png';
        }

        $category = new Category();

        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imageUrl;
        $category->save();

        Toastr::success('Tag Updated Successfully', 'success');

        return redirect()->route('admin.category.index');
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
