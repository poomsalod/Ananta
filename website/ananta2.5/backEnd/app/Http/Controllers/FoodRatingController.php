<?php

namespace App\Http\Controllers;

use App\Models\Category_food;
use App\Models\Food;
use App\Models\Food_rating;
use App\Models\Step_of_food;
use App\Models\Igd_of_food;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use PDO;

class FoodRatingController extends Controller
{
    function show_food()
    {
        // $user = User_profile::find($id);
        // $user = User_profile::get('user_id');
        // $food = Food::find($id);
        $cate_food = Category_food::orderBy('name')->get();
        $food_info = Food::latest();
        $count = $food_info->count();
        $food_info = $food_info->paginate(30);

        // dd($count);
        // $rating_user = Food_rating::where('food_id')->sum('rating_score');


        return view('Users.add_food_rating', compact('count', 'food_info', 'cate_food'))->with('i', (request()->input('page', 1) - 1) * 30);
    }

    function addfood_data(Request $request)
    {

        // dd($request);
        $request->validate([

            'user_id' => ['required'],
            'food_id' => ['required'],
            'score_rating' => ['required']
        ]);


        $food_xx = Food_rating::Where('food_id',$request->get('food_id'))->where('user_id',$request->get('user_id'))->latest()->count();

        if ($food_xx != 0) {
            $reting_menu = Food_rating::Where('food_id',$request->get('food_id'))->where('user_id',$request->get('user_id'))->get();
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

    function search_food(Request $request)
    {

        $cate_food = Category_food::orderBy('name')->get();

        if ($request->get('category') == 0) {

            if ($request->get('search') != null) {
                $search = $request->get('search');
                $food_info = Food::Where('name', 'like', '%' . $search . '%')->latest();
            } else {
                $food_info = Food::latest();
            }
        } else {
            if ($request->get('search') != null) {
                $search = $request->get('search');
                $food_info = Food::Where('name', 'like', '%' . $search . '%')->where('cate_food_id', $request->get('category'))->latest();
            } else {
                $food_info = Food::Where('cate_food_id', $request->get('category'))->latest();
            }
        }

        $count = $food_info->count();
        $food_info = $food_info->paginate(10);
        $food_info->append($request->all());
        return view('Users.add_food_rating', compact('count', 'food_info', 'cate_food'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    function show_menu_rating($id)
    {
        
        $ratingDB = Food_rating::where('user_id', $id);
        $count = $ratingDB->count();
        $ratingDB = $ratingDB->paginate(10);


        return view('Users.Menu_rating', compact('ratingDB', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function show($id ,$id_user)
    {
        $food = Food::find($id);
        $category_food = Category_food::all();

        $iof = Igd_of_food::with("igd_info.cate_igd")->where('food_id', $id)->latest();
        $count_iof = $iof->count();
        $iof = $iof->get();

        $step = Step_of_food::where('food_id',  $id)->orderBy('order')->latest();
        $count_step = $step->count();
        $step = $step->get();


        $rating_user = Food_rating::where('user_id',$id_user)->where('food_id', $id)->count();
        if($rating_user ==  0){
            $rating = 0;
        } else{
            $rating_user = Food_rating::where('user_id',$id_user)->where('food_id', $id)->get();
            // dd($rating_user);
            $rating = 0;
            foreach($rating_user as $key => $value){
                $rating = $value->rating_score; 
            }
        }
        

        return view('Users.ViewMenu_AddRating', compact('food', 'category_food', 'iof', 'count_iof', 'step', 'count_step', 'rating'));
    }
}
