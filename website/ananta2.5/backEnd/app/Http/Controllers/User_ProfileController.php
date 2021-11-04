<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_profile;
use App\Http\Controllers\Auth;
use App\Models\Account;
use Dotenv\Validator;
use Illuminate\Auth\Events\Validated;
use App\Models\User_nutrition;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class User_ProfileController extends Controller
{
    public function show_basic_info($id)
    {
        // dd('view');
        $data = User_nutrition::where('user_id',$id)->first();
        return view('Users.edit_profile', compact('data'));
    }

    public function show_data_profile($id)
    {
        // dd('view');
        $data = User_nutrition::where('user_id',$id)->first();
        return view('Users.User_profile', compact('data'));
    }

    public function show_account_username($id)
    {
        // dd('view');
        $data = User_nutrition::find($id);
        return view('Users.User_profile', compact('data'));
    }

    public function update_username(Request $request)
    {
        // dd($request);
        $request->validate([

            'user_id' => ['required'],
            'username' => ['required'],

        ]);

        $username = Account::find($request->get('user_id'));
        $username->username = $request->get('username');
        $username->save();
        return redirect()->back()->with('success', 'เรียบร้อย');
    }

    public function update_image_user(Request $request)
    {
        // dd($request);
        $image_user = User_profile::find($request->get('user_id'));
        $request->validate([
                'img' => 'required|image|mimes:jpeg,png,jpg,webp|max:1024',
            ], [
                'img.required' => "กรุณาอัพโหลดรูปภาพ",
                'img.mimes' => "รูปภาพต้องเป็นไฟล์ jpeg,png,jpg,webp",
                'img.max' => "รูปภาพต้องมีขนาดไม่เกิน 1 Mb",
                'img.image' => "กรุณาเลือกไฟล์ที่เป็นรูปภาพ",
            ]);

        if ($request->hasFile('img')) {
            
            $image = $request->file('img');
            $new_name = time() . '.' . $image->getClientOriginalExtension();
            Storage::delete('/public/images/user/' . $image_user->image);
            //$request->img->storeAs('images/igd', $new_name, 'public');

            $img = Image::make($image->path());
            $img->resize(400, 400, function ($const) {
                $const->aspectRatio();
            })->save(storage_path() . '/app/public/images/user/' . $new_name);

            $image_user->image = $new_name;
        }

        $image_user->save();
        return redirect()->back()->with('success', 'เรียบร้อย');

    }

    // public function save_image(Request $request)
    // {
    //     $user = new User_profile();
    //     if ($request->hasFile('image')) {
    //         $completeFileName = $request->file('image')->getClientOriginalName();
    //         $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
    //         $extension = $request->file('image')->getClientOriginalExtension();
    //         $compPic = str_replace(' ', '_', $fileNameOnly) . '-' . rand() . '_' . time() . '.' . $extension;
    //         $path = $request->file('image')->storeAs('public/users', $compPic);
    //     }
    //     if ($user->save()) {
    //         echo 200;
    //     } else {
    //         echo 700;
    //     }
    // }
}
