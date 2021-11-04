<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Igd_infoController;
use App\Http\Controllers\Cate_igdController;

use App\Http\Controllers\FoodController;
use App\Http\Controllers\Cate_foodController;
use App\Http\Controllers\UserHomeController;


use App\Http\Controllers\UserNutritionController;
use App\Http\Controllers\User_ProfileController;
use App\Http\Controllers\FoodRatingController;
use App\Http\Controllers\Food_allergyController;
use App\Http\Controllers\Stock_igd_Controller;
use App\Http\Controllers\Manage_accountController;
use App\Models\Food_rating;
use App\Models\User_profile;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Http;

Route::get('/food/calallfood', [FoodController::class, 'calallfood']);
Auth::routes();
Route::group(['middleware' => ['guest']], function () {
    Route::get('/', [LoginController::class, 'index']);
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('checklogin', [LoginController::class, 'login'])->name('checklogin');

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('createregister', [RegisterController::class, 'register'])->name('createregister');

    Route::get('/admin/register', [RegisterController::class, 'admin_from'])->name('admin_register');
    Route::post('/admin/createregister', [RegisterController::class, 'admin_register'])->name('admin_createregister');
});

Route::group(['middleware' => ['isAdmin', 'auth']], function () {

    Route::get('/igd-info/index', [Igd_infoController::class, 'index'])->name('admin_index');
    Route::get('/igd-info/create', [Igd_infoController::class, 'show_addIgd_info']);
    Route::post('/igd-info/add', [Igd_infoController::class, 'addIgd_info']);
    Route::get('/igd-info/edit/{id}', [Igd_infoController::class, 'show_editIgd_info']);
    Route::post('/igd-info/update', [Igd_infoController::class, 'editIgd_info']);
    Route::get('/igd-info/search/', [Igd_infoController::class, 'search']);

    Route::get('/igd-info/cate/index', [Cate_igdController::class, 'show_Igd_info_cate']);
    Route::get('/igd-info/cate/create', [Cate_igdController::class, 'show_addIgd_info_cate']);
    Route::post('/igd-info/cate/add', [Cate_igdController::class, 'addIgd_info_cate']);
    Route::get('/igd-info/cate/edit/{id}', [Cate_igdController::class, 'show_editIgd_info_cate']);
    Route::post('/igd-info/cate/update', [Cate_igdController::class, 'editIgd_info_cate']);
    Route::post('/igd-info/cate/delete/{id}', [Cate_igdController::class, 'desIgd_info_cate']);


    Route::get('/food/index', [FoodController::class, 'index'])->name('admin_index2');
    Route::get('/food/create', [FoodController::class, 'show_addFood']);
    Route::post('/food/add', [FoodController::class, 'addFood']);
    Route::get('/food/search/', [FoodController::class, 'search']);
    Route::get('/food/show/{id}', [FoodController::class, 'show'])->name('show_food');
    Route::get('/food/show/edit/{id}', [FoodController::class, 'show_editFood']);
    Route::post('/food/show/update', [FoodController::class, 'editFood']);
    Route::get('/food/show/create/igd/{id}', [FoodController::class, 'show_addigd']);
    Route::get('/food/search/igd', [FoodController::class, 'search_igd']);
    Route::post('/food/show/add/igd', [FoodController::class, 'addigd']);
    Route::get('/food/show/add/igd/detail/{food_id}/{igd_id}', [FoodController::class, 'show_add_detail_igd']);
    Route::get('/food/show/edit/igd/detail/{iof_id}', [FoodController::class, 'show_edit_detail_igd']);
    Route::post('/food/show/update/igd', [FoodController::class, 'updateIgd']);
    Route::post('/food/show/igd/delete/{id}', [FoodController::class, 'deIgd']);

    Route::get('/food/show/create/step/{id}', [FoodController::class, 'show_addstep']);
    Route::post('/food/show/add/step', [FoodController::class, 'addstep']);
    Route::get('/food/show/edit/step/{id}', [FoodController::class, 'show_editstep']);
    Route::post('/food/show/update/step', [FoodController::class, 'updateStep']);
    Route::post('/food/show/step/delete/{id}', [FoodController::class, 'deStep']);

    Route::get('/food/cate/index', [Cate_foodController::class, 'show_Food_cate']);
    Route::get('/food/cate/create', [Cate_foodController::class, 'show_addFood_cate']);
    Route::post('/food/cate/add', [Cate_foodController::class, 'addFood_cate']);
    Route::get('/food/cate/edit/{id}', [Cate_foodController::class, 'show_editFood_cate']);
    Route::post('/food/cate/update', [Cate_foodController::class, 'editFood_cate']);
    Route::post('/food/cate/delete/{id}', [Cate_foodController::class, 'desFood_cate']);

    Route::get('/admin/account/index', [Manage_accountController::class, 'index']);
    Route::get('/admin/account/show', [Manage_accountController::class, 'show']);
    Route::post('/admin/account/add', [Manage_accountController::class, 'add']);
    Route::post('/admin/account/edit', [Manage_accountController::class, 'edit']);

    Route::get('test-responsive', function () {
        return view('test-responsive');
    });
    Route::get('test', [FoodController::class, 'test']);
});


//****************************************************USER**************************************************** */


Route::group(['middleware' => ['isUser', 'auth']], function () {

    Route::get('/user/home', [UserHomeController::class, 'home'])->name('user_home');

    // หน้าของข้อมูลส่วนตัว user
    Route::get('/setting/nutrition/{id}', [UserNutritionController::class, 'Edit_data']);


    // add Data to MySqlAdmin

    // menu rating
    Route::get('/rating_menu', [FoodRatingController::class, 'show_food']);
    // add menu rating to page menu rating
    // Route::post('/add_data_rating',[FoodRatingController::class, 'addfood_data']);
    // search menu in menu totle
    Route::get('/show_food_data', [FoodRatingController::class, 'search_food']);
    // show menu rating add profile 
    Route::get('/show_data_rating/{id}', [FoodRatingController::class, 'show_menu_rating'])->name('add_rating');

    Route::get('/menu/rating/{id}/{id_user}', [FoodRatingController::class, 'show']);

    Route::post('/ViewMenu_AddRating', [FoodRatingController::class, 'addfood_data']);
    Route::post('/addrating', [FoodRatingController::class, 'addfood_data']);

    Route::get('/edit/nutrition/', function () {
        return view('Users.edit_nutrition');
    });

    Route::post('edit/profile/username/', [User_ProfileController::class, 'update_username']);


    Route::get('edit/profile/username/{id}', function () {
        return view('Users.edit_username');
    });

    Route::get('/setting/profile/{id}', [User_ProfileController::class, 'show_data_profile']);
    // โชร์ข้อมูลที่จะแก้ไข ของuser
    Route::get('/edit/profile/{id}', [User_ProfileController::class, 'show_basic_info']);
    Route::post('/edti/profile/update', [UserNutritionController::class, 'Edit_data']);

    Route::post('/edti/profile/update/image', [User_ProfileController::class, 'update_image_user']);


    Route::get('/show/add/nutrition/', [UserNutritionController::class, 'show_add_data'])->name('add_nutrition');

    //
    // Route::post('/add/profile/', [UserNutritionController::class, 'add_data'])->name('add_profile');

    // Route::get('/show/food_allergy/', [Food_allergyController::class, 'index']);
    // Route::get('/show/food_allergy/add', [Food_allergyController::class, 'show_add']);
    // Route::post('/show/food_allergy/create', [Food_allergyController::class, 'addigd']);
    // Route::get('/search/igd/', [Food_allergyController::class, 'search_igd']);

    //
    Route::post('/add/profile/', [UserNutritionController::class, 'add_data'])->name('add_profile');

    Route::get('/show/food_allergy/', [Food_allergyController::class, 'index']);
    Route::get('/show/food_allergy/add', [Food_allergyController::class, 'show_add']);
    Route::post('/show/food_allergy/create', [Food_allergyController::class, 'addigd']);
    Route::get('/food_allergy/search/igd/', [Food_allergyController::class, 'search_igd']);
    Route::post('/show/food_allergy/delete/{id}', [Food_allergyController::class, 'deIgd']);
    Route::get('/show/food_allergy/edit/{id}', [Food_allergyController::class, 'show_edit']);
    Route::post('/show/food_allergy/edit', [Food_allergyController::class, 'edit_addigd']);

    // คลังวัตถุดิบ
    Route::get('/show/igd_stock/', [Stock_igd_Controller::class, 'index']);
    Route::get('/show/igd_stock/add', [Stock_igd_Controller::class, 'show_add']);
    Route::post('/show/igd_stock/create', [Stock_igd_Controller::class, 'addigd']);
    Route::get('/search/igd/', [Stock_igd_Controller::class, 'search_igd']);
    Route::post('/show/igd_stock/delete/{id}', [Stock_igd_Controller::class, 'deIgd']);
    Route::get('/show/igd_stock/edit/{id}', [Stock_igd_Controller::class, 'show_edit']);
    Route::post('/show/igd_stock/update', [Stock_igd_Controller::class, 'edit_data']);
});

//***************************************************************************************************************************************** */


Route::get('tf2', function () {
    return view('train');
});

Route::get('python', function () {
    return view('runPython');
});

Route::get('test', function () {
    $body = '{"instances": [{input_1:["1"]}]}';
    $response = Http::withBody('{"instances":[{"input_1": "1"}]}', 'text/plain')->post('http://localhost:8606/v1/models/recomm/versions/1:predict');
    // dd($response);
    // dd(response()->json($response));
    $response2 = json_encode($response);
    $data = json_decode($response);
    $data2 = json_decode($response2);
    $data3 = json_decode(json_encode($response));
    // dd($response);
    var_dump($data);
    // return $response;
    return view('test', compact('data'));
});

Route::get('check/user/rating', function () {
    // $userNoRat = [];
    // $userProfile = User_profile::get()->all();
    // foreach ($userProfile as $key => $value) {
    //     $countUserRat = Food_rating::where('user_id', $value->user_id)->count();
    //     if ($countUserRat == 0) {
    //         $userNoRat[] = $value->user_id;
    //     }
    // }

    // $reting_menu = new Food_rating([
    //     'user_id' => 11,
    //     'food_id' => 321,
    //     'rating_score' => 4
    // ]);
    // $reting_menu->save();

    $ck = Food_rating::get()->all();
    dd('success');
});

Route::get('download/rating/csv', function () {

    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $db = "ananta2_6";
    try {

        $conn = mysqli_connect($servername, $username, $password, $db);
        //echo "Connected successfully"; 

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=rating.csv');
        $output = fopen("php://output", "w");
        fputcsv($output, array('food_id', 'user_id', 'rating'));
        $query = "SELECT food_id , user_id , rating_score from food_rating ORDER BY food_id";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
        }
        fclose($output);

    } catch (exception $e) {
        echo "Connection failed: " . $e->getMessage();
    }
});
