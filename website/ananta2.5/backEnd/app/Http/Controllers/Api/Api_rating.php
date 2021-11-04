<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food_rating;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Double;

class Api_rating extends Controller
{
    function addfood_data(Request $request)
    {

        // dd($request);
        $request->validate([

            'user_id' => ['required'],
            'food_id' => ['required'],
            'score_rating' => ['required']
        ]);


        $food_xx = Food_rating::Where('food_id', $request->get('food_id'))->where('user_id', $request->get('user_id'))->latest()->count();

        if ($food_xx != 0) {
            $reting_menu = Food_rating::Where('food_id', $request->get('food_id'))->where('user_id', $request->get('user_id'))->get();
            $reting_menu = $reting_menu[0];
            $reting_menu->rating_score = $request->get('score_rating');
            $reting_menu->save();
            return redirect()->back()->with('success', 'แก้ไขคะแนนรายการเมนูอาหารเรียบร้อยแล้ว');
            // return redirect()->back()->with('error', 'มีรายการเมนูอาหารนี้อยู่แล้ว');
        } else {

            $reting_menu = new Food_rating([
                'user_id' => $request->get('user_id'),
                'food_id' => $request->get('food_id'),
                'rating_score' => $request->get('score_rating')
            ]);
            $reting_menu->save();
            return redirect()->back()->with('success', 'เพิ่มคะแนนรายการเมนูอาหารเรียบร้อยแล้ว');
        }
    }

    function get_userRating(Request $request)
    {
        $rating = Food_rating::where('user_id', $request->get('user_id'))->where('food_id', $request->get('food_id'))->latest();
        $count = $rating->count();
        $rating = $rating->get();
        
        if ($count == 0) {
            $score = 0;
        } else {
            $score = $rating[0]->rating_score;
        }

        $jsonfood = [];
        $json = [
            "rating" => $score+0.1,
        ];
        $jsonfood[] = $json;
        // dd($score.'.0');
       
        $response = json_encode($json, JSON_UNESCAPED_UNICODE);
        return response($response);
        // return response()->json($foods);
    }
}
