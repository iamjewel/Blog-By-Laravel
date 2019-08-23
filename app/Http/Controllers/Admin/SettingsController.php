<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings');
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'required|image',
        ]);

        $image = $request->file('image');
        $slug = str_slug($request->name);

        $user = User::findOrFail(Auth::id());

        if (isset($image)) {

            //Image Name
            $imageName = $slug . '-' . time() . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('profile')) {
                Storage::disk('public')->makeDirectory('profile');
            }

            //Delete old image form profile folder
            if (Storage::disk('public')->exists('profile/' . $user->image)) {
                Storage::disk('public')->delete('profile/' . $user->image);
            }

            $profile = Image::make($image)->resize(500, 500)->stream();
            Storage::disk('public')->put('profile/' . $imageName, $profile);

        } else {
            $imageName = $user->image;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $imageName;
        $user->about = $request->about;
        $user->save();

        Toastr::success('Profile Successfully Updated :)', 'Success');
        return redirect()->back();
    }
}
