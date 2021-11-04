<?php

namespace App\Http\Controllers;

use App\Models\User_nutrition;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserNutritionController extends Controller
{
    function edit_data(Request $request)
    {

        // dd($request);

        $request->validate([

            'user_id' => ['required'],
            'f_name' => ['required'],
            'l_name' => ['required'],
            'gender' => ['required'],
            // 'age' => ['required', 'max:3'],
            'birthday' => ['required'],
            'weight' => ['required'],
            'height' => ['required'],
            'activity' => ['required'],

        ]);

        // วันเกิดเป็นอายุ
        $age = Carbon::parse($request->get('birthday'))->diff(Carbon::now())->y;

        //หา bmi
        $height = $request->get('height') / 100;
        $bmi = $request->get('weight') / ($height ** 2);
        
        
        // คำนวน BMR
        if ($request->get('gender') == 1) {
            $bmr = (((66.47 + (13.75 * $request->get('weight'))) + (5.003 * $request->get('height'))) - (6.755 * $age));
        } else {
            $bmr = (((655.1 + (9.563 * $request->get('weight'))) + (1.85 * $request->get('height'))) - (4.676 * $age));
        }

        //คำนวน tdee
        if($bmi>=30){
            $tdee = $request->get('activity') * $bmr - 200;
            $analyze_bmi = 5;
        }elseif(25 <= $bmi && $bmi <= 29.9){
            $tdee = $request->get('activity') * $bmr - 200;
            $analyze_bmi = 4;
        }elseif(23 <= $bmi && $bmi <= 24.9){
            $tdee = $request->get('activity') * $bmr - 200;
            $analyze_bmi = 3;
        }elseif(18.5 <= $bmi && $bmi <= 22.9){
            $tdee = $request->get('activity') * $bmr;
            $analyze_bmi = 2;
        }elseif($bmi < 18.5){
            $tdee = $request->get('activity') * $bmr + 200;
            $analyze_bmi = 1;
        }




        $userdata = User_nutrition::where('user_id',$request->get('user_id'))->first();
        $userdata->gender = $request->get('gender');
        $userdata->weight = $request->get('weight');
        $userdata->height = $request->get('height');
        $userdata->activity = $request->get('activity');
        $userdata->bmr = $bmr;
        $userdata->bmi = $bmi;
        $userdata->tdee = $tdee;
        $userdata->analyze_bmi = $analyze_bmi;
        $userdata->save();

        $dataprofile = User_profile::find($request->get('user_id'));
        $dataprofile->f_name = $request->get('f_name');
        $dataprofile->l_name = $request->get('l_name');
        $dataprofile->birthday = $request->get('birthday');
        $dataprofile->save();
        return redirect()->back()->with('success', 'เรียบร้อย');

    }

    function add_data(Request $request)
    {

        // dd($request);

        $request->validate([

            'user_id' => ['required'],
            'gender' => ['required'],
            'weight' => ['required'],
            'height' => ['required'],
            'activity' => ['required'],

        ]);

        // วันเกิดเป็นอายุ
        $userprofile = User_profile::find($request->get('user_id'));
        $birthday = $userprofile->birthday;
        $age = Carbon::parse($birthday)->diff(Carbon::now())->y;
        
        //หา bmi
        $height = $request->get('height') / 100;
        $bmi = $request->get('weight') / ($height ** 2);

        // คำนวน BMR
        if ($request->get('gender') == 1) {
            $bmr = (((66.47 + (13.75 * $request->get('weight'))) + (5.003 * $request->get('height'))) - (6.755 * $age));
        } else {
            $bmr = (((655.1 + (9.563 * $request->get('weight'))) + (1.85 * $request->get('height'))) - (4.676 * $age));
        }

        //คำนวน tdee
        if($bmi>=30){
            $tdee = $request->get('activity') * $bmr - 200;
            $analyze_bmi = 5;
        }elseif(25 <= $bmi && $bmi <= 29.9){
            $tdee = $request->get('activity') * $bmr - 200;
            $analyze_bmi = 4;
        }elseif(23 <= $bmi && $bmi <= 24.9){
            $tdee = $request->get('activity') * $bmr - 200;
            $analyze_bmi = 3;
        }elseif(18.5 <= $bmi && $bmi <= 22.9){
            $tdee = $request->get('activity') * $bmr;
            $analyze_bmi = 2;
        }elseif($bmi < 18.5){
            $tdee = $request->get('activity') * $bmr + 200;
            $analyze_bmi = 1;
        }
        
        //saveในตางรางใหม่
        $userdata = new User_nutrition([
            'user_id' => $request->get('user_id'),
            'gender' => $request->get('gender'),
            'weight' => $request->get('weight'),
            'height' => $request->get('height'),
            'activity' => $request->get('activity'),
            'bmr' => $bmr,
            'bmi' => $bmi,
            'analyze_bmi' => $analyze_bmi,
            'tdee' => $tdee,
        ]);
        $userdata->save();
        
        return redirect()->route('add_rating',$request->get('user_id'));
        // return redirect()->back()->with('success', 'เรียบร้อย');



        // dd($userdata->bmi);

    }

    function show_add_data()
    {
        return view('Users.show_add_nutrition');
    }
}
