<?php

use App\Http\Controllers\Api\Api_food;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Api_auth;
use App\Http\Controllers\Api\Api_cate;
use App\Http\Controllers\Api\Api_igd;
use App\Http\Controllers\Api\Api_rating;
use App\Http\Controllers\Api\Api_stock;
use App\Http\Controllers\Api\Api_userProfile;
use App\Models\Food;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Basic

Route::get('/image', function (Request $request) {
    $id = $request->get('id');
    $food = Food::find($id);

    return response()->file(public_path("/storage/images/food/".$id));
});


Route::get('/basic', function () {
    return response()->json([1, 2, 3, 4, 5]);
});
Route::get('/basics', function (Request $request) {
    $id = $request->get('id');
    return response()->download(public_path('/storage/images/food/'.$id));
});
Route::get('/food/no/rating', [Api_food::class, 'get_noRat']);


Route::get('/recfood', [Api_food::class, 'get_recFood']);
Route::post('/add/history', [Api_food::class, 'add_history']);

Route::get('/cal/nu', [Api_food::class, 'cal_score_nutrition']);

Route::get('/cal', [Api_food::class, 'cal_score_sum']);

//public
Route::post('/register', [Api_auth::class, 'register']);
Route::post('/login', [Api_auth::class, 'login']);

//protected
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('numbers', function () {
        return response()->json([1, 2, 3, 4, 5]);
    });

    Route::get('profile', function () {
        $name = auth()->user()->user_profile->name;
        return response()->json(['name' => $name]);
    });

    Route::post('/logout', [Api_auth::class, 'logout']);


    Route::post('/allfood', [Api_food::class, 'get_allFood']);
    Route::post('/onefood', [Api_food::class, 'get_oneFood']);
    Route::post('/foodigd', [Api_food::class, 'get_Food_igd']);
    Route::post('/igdinfo', [Api_food::class, 'get_igd_info']);
    Route::post('/foodstep', [Api_food::class, 'get_Food_step']);
    Route::post('/history', [Api_food::class, 'get_history']);
    Route::post('/dayeat', [Api_food::class, 'get_dayEat']);
    Route::post('/user/profile', [Api_userProfile::class, 'get_userProfile']);
    Route::post('/user/nutrition', [Api_userProfile::class, 'get_userNutrition']);
    Route::post('/food/recommend', [Api_food::class, 'get_foodRecommended']);
    
    Route::get('/catefood', [Api_cate::class, 'getCateFood']);

    Route::post('/addrating', [Api_rating::class, 'addfood_data']);
    Route::post('/getrating', [Api_rating::class, 'get_userRating']);

    Route::post('/getigd', [Api_igd::class, 'get_igdForAllergy']);
    Route::post('/addfoodallergy', [Api_igd::class, 'addFoodAllergy']);
    Route::get('/cateigd', [Api_igd::class, 'getCateIgd']);
    Route::post('/getfoodallergy', [Api_igd::class, 'get_FoodAllergy']);
    Route::post('/deletefoodallergy', [Api_igd::class, 'deIgd']);

    Route::post('/getigdstock', [Api_stock::class, 'get_igdForStock']);
    Route::post('/addstock', [Api_stock::class, 'addStock']);
    Route::post('/getstock', [Api_stock::class, 'getStock']);
    Route::post('/deletestock', [Api_stock::class, 'deStock']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
