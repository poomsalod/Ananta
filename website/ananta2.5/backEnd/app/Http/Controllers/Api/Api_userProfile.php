<?php

namespace App\Http\Controllers\Api;

use App\Models\User_profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User_nutrition;

class Api_userProfile extends Controller
{
    function get_userProfile(Request $request){
        $request->validate([
            'account_id' => 'required', 
        ]);
        $user_profile = User_profile::where('account_id' , $request->get('account_id'))->get();
        return response()->json($user_profile);
    }

    function get_userNutrition(Request $request){
        $request->validate([
            'user_id' => 'required', 
        ]);
        $user_nutrition = User_nutrition::where('user_id' , $request->get('user_id'))->latest()->get();

        $response = json_encode($user_nutrition, JSON_UNESCAPED_UNICODE);
        return response($response);
        // return response()->json($user_nutrition);
    }
}
