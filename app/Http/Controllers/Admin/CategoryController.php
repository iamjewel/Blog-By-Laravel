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


            //Image Name
            $imageName = $slug . '-' . time() . '.' . $image->getClientOriginalExtension();

            //Check and Make Category Img Dir.
            if (!Storage::disk('public')->exists('category')) {
                Storage::disk('public')->makeDirectory('category');
            }

            //Resize & Upload Image For Category
            $category = Image::make($image)->resize(1600, 479)->stream();
            Storage::disk('public')->put('category/' . $imageName, $category);


            //Check and Make Category Slider Img Dir.
            if (!Storage::disk('public')->exists('category/slider')) {
                Storage::disk('public')->makeDirectory('category/slider');
            }

            //Image Resize & Upload For Category Slider
            $categorySliderImage = Image::make($image)->resize(500, 333)->stream();
            Storage::disk('public')->put('category/slider/' . $imageName, $categorySliderImage);

        } else {
            $imageName = 'default.png';
        }

        $category = new Category();

        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imageName;
        $category->save();

        Toastr::success('Category Added Successfully', 'success');

        return redirect()->route('admin.category.index');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {

        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }


    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $this->validate($request, [
            'name' => 'required|unique:categories,name,' . $category->id,
            'image' => 'mimes:jpeg,png,jpg'
        ]);

        $image = $request->file('image');
        $slug = str_slug($request->name);

        if (isset($image)) {

            //Image Name
            $imageName = $slug . '-' . time() . '.' . $image->getClientOriginalExtension();

            //Check and Make Category Image Dir.
            if (!Storage::disk('public')->exists('category')) {
                Storage::disk('public')->makeDirectory('category');
            }

            //Delete Old Category Image
            if (Storage::disk('public')->exists('category/' . $category->image)) {
                Storage::disk('public')->delete('category/' . $category->image);
            }

            //Image Upload For Category
            $categoryImage = Image::make($image)->resize(1600, 479)->stream();
            Storage::disk('public')->put('category/' . $imageName, $categoryImage);


            //Check and Make Category Slider Img Dir.
            if (!Storage::disk('public')->exists('category/slider')) {
                Storage::disk('public')->makeDirectory('category/slider');
            }

            //Delete Old Category Slider Image
            if (Storage::disk('public')->exists('category/slider/' . $category->image)) {
                Storage::disk('public')->delete('category/slider/' . $category->image);
            }

            //Image Upload For Category Slier
            $categorySliderImage = Image::make($image)->resize(500, 333)->stream();
            Storage::disk('public')->put('category/slider/' . $imageName, $categorySliderImage);

        } else {
            $imageName = $category->image;
        }

        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imageName;
        $category->save();

        Toastr::success('Category Updated Successfully', 'success');

        return redirect()->route('admin.category.index');
    }


    public function destroy($id)
    {
        $category = Category::find($id);

        //Delete Category Image
        if (Storage::disk('public')->exists('category/' . $category->image)) {
            Storage::disk('public')->delete('category/' . $category->image);
        }

        //Delete Category Slider Image
        if (Storage::disk('public')->exists('category/slider/' . $category->image)) {
            Storage::disk('public')->delete('category/slider/' . $category->image);
        }

        $category->delete();

        Toastr::success('Category Deleted Successfully', 'success');

        return redirect()->route('admin.category.index');
    }
}
