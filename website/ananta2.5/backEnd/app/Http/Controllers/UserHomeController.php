<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Food;
use App\Models\Category_food;
use App\Models\Food_rating;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserHomeController extends Controller
{
    function home()
    {
        // $user_id = auth()->user()->user_profile->user_id;
        // $response = Http::withBody('{"instances":[{"input_1": "'.$user_id.'"}]}', 'text/plain')->post('http://localhost:8606/v1/models/recomm/versions/1:predict');
        // $data = json_decode($response);
        // $array = $data->predictions;
        // $output = $array[0];
        // $output_2 = $output->output_2;
        // $foodrec = [];
        // for($i = 0 ;$i < count($output_2);$i++){
        //     $foodrec[$i] = Food::find($output_2[$i]);
        // }

        // // foreach($output as $key => $value){
        // //     $a = $value[]
        // // }

        // // $cate_food = Category_food::all();
        // // $food = Food::latest()->paginate(10);
        // // dd($food);
        // // $count = $food->count();
        // // $food = $food->paginate(10);


        // return view('Users.User_home' , compact('foodrec'));



        
        $ratingDB = Food_rating::where('user_id', Auth::user()->user_profile->user_id);
        $count = $ratingDB->count();
        $ratingDB = $ratingDB->paginate(10);

        // $account = Account::find(Auth::user()->account_id);
        // $account->last_used_at = Carbon::now();
        // $account->save();
        return view('Users.Menu_rating', compact('ratingDB', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);

        // return view('Users.User_home');
    }
}
