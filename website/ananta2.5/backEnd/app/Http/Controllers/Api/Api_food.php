<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Api_history;
use App\Models\Eating_history;
use App\Models\Food;
use App\Models\Food_allergy;
use App\Models\Food_rating;
use App\Models\Food_recommended;
use App\Models\Igd_info;
use App\Models\Igd_of_food;
use App\Models\Step_of_food;
use App\Models\stock_igd;
use App\Models\User_nutrition;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;


class Api_food extends Controller
{
    function get_allFood(Request $request)
    {
        $user_id = $request->get('user_id');
        $foods = Food::latest()->get();
        // $response = json_encode($foods, JSON_UNESCAPED_UNICODE);

        $jsonfood = [];
        foreach ($foods as $key => $value) {
            $json = [
                "food_id" => $value->food_id,
                "name" => $value->name,
                "image" => $value->image,
                "cate_food_id" => $value->cate_food_id,
                "calorie" => $value->calorie,
                "fat" => $value->fat,
                "protein" => $value->protein,
                "carbohydrate" => $value->carbohydrate,
                "fiber" => $value->fiber,
                "percent_user_cook" => $this->calStock($value->food_id, $user_id)
            ];
            $jsonfood[] = $json;
        }
        $response = json_encode($jsonfood, JSON_UNESCAPED_UNICODE);

        return response($response);
        // return response()->json($foods);
    }

    function get_oneFood(Request $request)
    {

        $foods = Food::find($request->get('id'));
        $response = json_encode($foods, JSON_UNESCAPED_UNICODE);
        return response($response);
        // return response()->json($foods);
    }

    function get_Food_igd(Request $request)
    {
        $igd_of_food = Igd_of_food::where('food_id', $request->get('id'))->latest()->get();

        $response = json_encode($igd_of_food, JSON_UNESCAPED_UNICODE);
        return response($response);
        // return response()->json($igd_of_food);
    }

    function get_igd_info(Request $request)
    {
        $igd = Igd_info::find($request->get('id'));

        $response = json_encode($igd, JSON_UNESCAPED_UNICODE);
        return response($response);
        // return response()->json($igd);
    }

    function get_food_step(Request $request)
    {
        $step = Step_of_food::where('food_id', $request->get('id'))->orderBy('order')->latest()->get();
        // $response = json_encode($step,JSON_UNESCAPED_UNICODE);
        // return response($response);
        return response()->json($step);
    }

    function get_history(Request $request)
    {
        $history = Eating_history::where('user_id', $request->get('id'))->latest()->get();
        $historyArr = [];
        foreach ($history as $key => $value) {
            $food = Food::find($value->food_id);
            $dateTime = $value->created_at->addHours(7);
            $hisMo = new Api_history([
                'name' => $food->name,
                'image' => $food->image,
                'calorie' => $food->calorie,
                // 'date' => 1,
                // 'time' => 1,
                'date' => $dateTime->toDateString(),
                'time' => $dateTime->toTimeString(),
            ]);
            $historyArr[] = $hisMo;
        }
        $response = json_encode($historyArr, JSON_UNESCAPED_UNICODE);
        return response($response);
        // return response()->json($historyArr);
    }

    function get_dayEat(Request $request)
    {
        $dayEat = 0;
        $history = Eating_history::where('user_id', $request->get('id'))->latest()->get();
        foreach ($history as $key => $value) {
            if ($value->created_at->diff(Carbon::now())->y == 0) {
                if ($value->created_at->diff(Carbon::now())->m == 0) {
                    if ($value->created_at->diff(Carbon::now())->d == 0) {
                        $foodCal = Food::find($value->food_id);
                        $dayEat = $dayEat + $foodCal->calorie;
                    }
                }
            }
        }
        $user_nutrition = User_nutrition::where('user_id', $request->get('id'))->latest()->get();
        $tdee = $user_nutrition[0]->tdee;
        // $response = json_encode($step,JSON_UNESCAPED_UNICODE);
        // return response($response);
        return response()->json(["tdee" => floor($tdee), "dayEat" => floor($dayEat)]);
    }

    //การหา100เมนูจากโมเดล
    function get_recFood()
    {

        $user_profile = User_profile::latest()->get();

        foreach ($user_profile as $key => $value) {
            $user_recommended_count = Food_recommended::where('user_id', $value->user_id)->latest()->count();
            if ($user_recommended_count == 0) {


                $food_arr = '[';
                //len - 1 เพื่อแก้ , (มีทั้งหมด 350)
                for ($i = 0; $i < 349; $i++) {
                    $food_arr = $food_arr . ($i + 1) . ',';
                }
                $food_arr = $food_arr . '350]';

                $user_id = $value->user_id;
                $user_arr = '[';
                //len - 1 เพื่อแก้ , (มีทั้งหมด 350)
                for ($i = 0; $i < 349; $i++) {
                    $user_arr = $user_arr . $user_id . ',';
                }
                $user_arr = $user_arr . $user_id . ']';

                $body = '{"instances":[{"input_1":' . $food_arr . ' ,"input_2":' . $user_arr . ' }]}';
                $response = Http::withBody($body, 'text/plain')->post('http://localhost:8605/v1/models/recomm:predict');
                // // var_dump(json_decode($response));

                $data = json_decode($response);
                $array = $data->predictions;
                $foodResponse = [];
                for ($i = 0; $i < count($array); $i++) {
                    $floor_1 = $array[$i];
                    $foodResponse[] = $floor_1[0];
                }

                //เรียงลำดับ
                arsort($foodResponse);
                $loopCount = 0;
                foreach ($foodResponse as $key => $value) {
                    $foodrec = new Food_recommended([
                        'user_id' => $user_id,
                        'food_id' => $key + 1,
                        'score_nutrition' => 0,
                        'score_sum' => 1,
                        'igd_matching' => 0,
                    ]);
                    $foodrec->save();
                    $loopCount++;
                    //กำหนดจำนวนเมนูที่ต้องการ
                    if ($loopCount > 99) {
                        $loopCount = 0;
                        break;
                    }
                }
            } else {
            }
        }
    }

    function get_foodRecommended(Request $request)
    {
        $user_id = $request->get('user_id');
        

        //อัพเดทการใช้งาน
        $userLastUseAccount = User_profile::find($user_id);
        $userAccount_id = $userLastUseAccount->account->account_id;
        $userLastUse = Account::find($userAccount_id);
        $userLastUse->last_used_at = Carbon::now();
        $userLastUse->save();
        
        //ดึงเมนูจากโมเดลสำหรับ user ใหม่
        $this->get_recFoodNewUser($user_id);


        $this->cal_score_sum($user_id);
        $this->cal_score_nutrition($user_id);
        $foodAgy = Food_allergy::where('user_id', $user_id)->get();

        if ($request->get('cate_food_id')) {
            $foodrec = [];
            $foodrecget = Food_recommended::where('user_id', $user_id)->get();
            foreach ($foodrecget as $key => $value) {
                $foodinfo = Food::find($value->food_id);

                if ($foodinfo->cate_food_id == $request->get('cate_food_id')) {
                    $foodrec[] = $value;
                }
            }

            $count = count($foodrec);
            // dd($foodrec);

            $floor_4 = [];
            foreach ($foodrec as $key => $value) {
                $floor_4[] = $value->score_nutrition;
            }

            arsort($floor_4);

            $floor_5 = [];
            foreach ($floor_4 as $key => $value) {
                $floor_5[] = $foodrec[$key];
            }

            if ($count >= 3) {
                $num = 3;
            } else {
                $num = $count;
            }
            $food = [];
            for ($i = 0; $i < $num; $i++) {
                $foodModel = Food::where('food_id', $floor_5[$i]->food_id)->get();
                $food[] = $foodModel[0];
            }

            $jsonfood = [];
            foreach ($food as $key => $value) {
                $foodScore = Food_recommended::where('user_id', $user_id)->where('food_id', $value->food_id)->get();

                $json = [
                    "food_id" => $value->food_id,
                    "name" => $value->name,
                    "image" => $value->image,
                    "cate_food_id" => $value->cate_food_id,
                    "calorie" => $value->calorie,
                    "fat" => $value->fat,
                    "protein" => $value->protein,
                    "carbohydrate" => $value->carbohydrate,
                    "fiber" => $value->fiber,
                    "score_nutrition" => $foodScore[0]->score_nutrition,
                    "percent_user_cook" => $this->calStock($value->food_id, $user_id)
                ];
                $jsonfood[] = $json;
            }
            $response = json_encode($jsonfood, JSON_UNESCAPED_UNICODE);
            return response($response);
        } else {
            $foodrec = Food_recommended::where('user_id', $user_id)->get();
            $floor_agy_1 = [];
            foreach ($foodrec as $key => $valueRec) {
                $canEat = 0;
                foreach ($foodAgy as $key => $valueAgy) {
                    $iof = Igd_of_food::where('food_id', $valueRec->food_id)->where('igd_info_id', $valueAgy->igd_info_id)->latest()->count();
                    if ($iof != 0) {
                        $canEat = 1;
                    }
                }
                if ($canEat == 0) {
                    $floor_agy_1[] = $valueRec;
                }
            }




            $floor_1 = [];
            foreach ($floor_agy_1 as $key => $value) {
                $floor_1[] = $value->score_sum;
            }

            $floor_1 = [];
            foreach ($floor_agy_1 as $key => $value) {
                $floor_1[] = $value->score_sum;
            }
            //  เรียง score_sum จากมากไปน้อย
            arsort($floor_1);
            //  เพิ่มข้อมูลโมเดลตามตำแหน่งที่เรียงไว้
            $floor_2 = [];
            foreach ($floor_1 as $key => $value) {
                $floor_2[] = $floor_agy_1[$key];
            }

            //*******************ถ้ามีการบันทึกการรับประทานมากๆ ควรปรับให้น้อยลง*************************** */
            //คัด 40 เมนูแรกที่มี score_sum เยอะสุด
            $floor_3 = [];
            for ($i = 0; $i < 40; $i++) {
                $floor_3[] = $floor_2[$i];
            }

            //ดึงข้อมูล score_nutrition
            $floor_4 = [];
            foreach ($floor_3 as $key => $value) {
                $floor_4[] = $value->score_nutrition;
            }

            //เรียง score_nutrition จากมากไปน้อย
            arsort($floor_4);

            //คัด 15 เมนูแรกที่มี score_nutrition มากที่สุด
            $floor_5 = [];
            foreach ($floor_4 as $key => $value) {
                $floor_5[] = $floor_3[$key];
            }



            $foodResponse = [];
            $index_rendom = array_rand($floor_5, 10);
            for ($i = 0; $i < count($index_rendom); $i++) {
                $foodResponse[] = $floor_3[$index_rendom[$i]];
            }

            //ได้เมนูแนะนำ 3 เมนู
            $food = [];
            for ($i = 0; $i < 3; $i++) {
                //แบบไม่สุ่ม
                $foodModel = Food::where('food_id', $floor_5[$i]->food_id)->get();
                // //แบบสุ่ม
                // $foodModel = Food::where('food_id', $foodResponse[$i]->food_id)->get();
                $food[] = $foodModel[0];
            }


            $jsonfood = [];
            foreach ($food as $key => $value) {
                $foodScore = Food_recommended::where('user_id', $user_id)->where('food_id', $value->food_id)->get();



                $json = [
                    "food_id" => $value->food_id,
                    "name" => $value->name,
                    "image" => $value->image,
                    "cate_food_id" => $value->cate_food_id,
                    "calorie" => $value->calorie,
                    "fat" => $value->fat,
                    "protein" => $value->protein,
                    "carbohydrate" => $value->carbohydrate,
                    "fiber" => $value->fiber,
                    "score_nutrition" => $foodScore[0]->score_nutrition,
                    "percent_user_cook" => $this->calStock($value->food_id, $user_id)
                ];
                // $json = '{"food_id":'.$value->food_id.',"name":"'.$value->name.'","image":"'.$value->image.'","cate_food_id":'.$value->cate_food_id.',"calorie":'.$value->calorie.',"fat":'.$value->fat.',"protein":'.$value->protein.',"carbohydrate":'.$value->carbohydrate.',"fiber":'.$value->fiber.',"score_nutrition":'.$foodScore[0]->score_nutrition.'}';
                // $json = '{"food_id":'.$value->food_id.',"name":"'.$value->name.'","image":"'.$value->image.'","cate_food_id":'.$value->cate_food_id.',"calorie":'.$value->calorie.',"fat":'.$value->fat.',"protein":'.$value->protein.',"carbohydrate":'.$value->carbohydrate.',"fiber":'.$value->fiber.',"status":'.$value->status.',"addess":"'.$value->addess.'","admin_id":'.$value->admin_id.',"created_at":"'.$value->created_at.'","updated_at":"'.$value->updated_at.'"}';
                // dd($json);
                $jsonfood[] = $json;
            }
            $response = json_encode($jsonfood, JSON_UNESCAPED_UNICODE);
            // dd($response);

            //เพิ่มคำนวนscore_sum
            //เพิ่มคำนวนscore_nutrition

            // $response = json_encode($food, JSON_UNESCAPED_UNICODE);
            return response($response);
            // return response()->json($food);
        }
    }


    function cal_score_sum($user_id)
    {
        $foodrec = Food_recommended::where('user_id', $user_id)->get();
        // $history = Eating_history::where('user_id', $user_id)->get();
        // $date = $history[0]->created_at->toDateTimeString();
        // $history1 = Eating_history::where('user_id', $user_id)->latest()->get();

        foreach ($foodrec as $key => $value) {
            $foodup = Food_recommended::where('food_id', $value->food_id)->where('user_id', $user_id)->get();
            $foodup[0]->score_sum = $this->cal_history($user_id, $value->food_id);
            $foodup[0]->save();
        }
    }

    function cal_history($user_id, $food_id)
    {
        $history = Eating_history::where('food_id', $food_id)->where('user_id', $user_id)->latest();
        $check_count = $history->count();
        if ($check_count != 0) {
            $foodup = $history->get();
            $day = $foodup[$check_count-1]->created_at->diff(Carbon::now())->d;
            $score = 1.33 * (1 + ($day / 5));
            return $score;
        } else {
            $day_user = User_profile::where('user_id', $user_id)->get();
            $day = $day_user[0]->created_at->diff(Carbon::now())->d;
            $score = 1.33 * (1 + ($day / 5));

            return $score;
        }
    }

    function cal_score_nutrition($user_id)
    {
        $user_nu = User_nutrition::where('user_id', $user_id)->get();

        $tdee = $user_nu[0]->tdee;

        //โปรตีนกรัม
        $proG = $user_nu[0]->weight;

        //โปรตีนเป็นแคลอรี่
        $proToCal = $proG * 4;

        //หาเปอร์เซ็น
        $proPer = ($proToCal / $tdee) * 100;
        $carPer = 65 - ($proPer / 2);
        $fatPer = 35 - ($proPer / 2);

        //หา คาร์,ไขมัน เป็นแคลอรี่
        $carCal = $tdee * ($carPer / 100);
        $fatCal = $tdee * ($fatPer / 100);

        //หา คาร์,ไขมัน เป็นกรัม
        $carG = $carCal / 4;
        $fatG = $fatCal / 9;

        //หาแคลอรี่ต่อมื้อ
        $cal = $tdee / 3;

        //หาคาร์โบต่อมื้อ
        $car = $carG / 3;

        //หาโปรตีนต่อมื้อ
        $pro = $proG / 3;

        //หาไขมันต่อมื้อ
        $fat = $fatG / 3;

        //หาใยอาหารต่อมื้อ
        // $fib = 8.3;

        $foodrec = Food_recommended::where('user_id', $user_id)->get();
        foreach ($foodrec as $key => $value) {
            $food = Food::find($value->food_id);
            // $calDiff = abs($food->calorie - $cal);
            // $proDiff = abs($food->protein - $pro);
            // $carDiff = abs($food->carbohydrate - $car);
            // $fatDiff = abs($food->fat - $fat);
            // $fibDiff = abs($food->fiber - $fib);

            //แบบเดิม******************************************
            // $sumUserNu = $cal + $pro + $car + $fat + $fib;
            // $sumFoodNu = $food->calorie + $food->protein + $food->carbohydrate + $food->fat + $food->fib;
            // // $sumDiff = $calDiff+$proDiff+$carDiff+$fatDiff+$fibDiff;
            // // $sum1 = $calDiff.'/'.$proDiff.'/'.$carDiff.'/'.$fatDiff.'/'.$fibDiff;
            // $perFoodInUserNu =  abs(($sumFoodNu / $sumUserNu) - 1);
            //**********************************************
            $scoreCal = abs($food->calorie / $cal * 100);
            if ($scoreCal >= 200) {
                $sumScoreCal = 0;
            } elseif ($scoreCal > 100) {
                $sumScoreCal = abs(200 - $scoreCal) / 10;
            } else {
                $sumScoreCal = abs($scoreCal) / 10;
            }

            $scorePro = abs($food->protein / $pro * 100);
            if ($scorePro >= 200) {
                $sumScorePro = 0;
            } elseif ($scorePro > 100) {
                $sumScorePro = abs(200 - $scorePro) / 10;
            } else {
                $sumScorePro = abs($scorePro) / 10;
            }

            $scoreFat = abs($food->fat / $fat * 100);
            if ($scoreFat >= 200) {
                $sumScoreFat = 0;
            } elseif ($scoreFat > 100) {
                $sumScoreFat = abs(200 - $scoreFat) / 10;
            } else {
                $sumScoreFat = abs($scoreFat) / 10;
            }


            $scoreCar = abs($food->carbohydrate / $car * 100);
            if ($scoreCar >= 200) {
                $sumScoreCar = 0;
            } elseif ($scoreCar > 100) {
                $sumScoreCar = abs(200 - $scoreCar) / 10;
            } else {
                $sumScoreCar = abs($scoreCar) / 10;
            }


            $sumScore = ($sumScoreCal + $sumScorePro + $sumScoreFat + $sumScoreCar) / 4;




            $foodup = Food_recommended::where('food_id', $value->food_id)->where('user_id', $user_id)->get();
            $foodup[0]->score_nutrition = $sumScore;
            $foodup[0]->save();
        }
    }

    function calStock($food_id, $user_id)
    {
        $iof = Igd_of_food::where('food_id', $food_id)->where('importance', 1)->latest();

        $countIof = $iof->count();
        $iof = $iof->get();
        $sum = 0;

        foreach ($iof as $key => $value) {

            $stock_user = stock_igd::where('user_id', $user_id)->where('igd_info_id', $value->igd_info_id)->latest();
            $countStock = $stock_user->count();
            $stock_user = $stock_user->get();
            if ($countStock > 0) {
                if ($value->unit == 'ช้อนชา') {
                    $result = 5;
                } elseif ($value->unit == 'ช้อนโต๊ะ') {
                    $result = 15;
                } elseif ($value->unit == 'ถ้วยตวง') {
                    $result = 240;
                } else {
                    $result = 1;
                }
                $score = ($stock_user[0]->value / ($value->value * $result)) * 100;
                if ($score > 100) {
                    $sum = $sum + 100;
                } else {
                    $sum = $sum + $score;
                }
            }
        }
        $percent = $sum / $countIof;
        return intval($percent);
    }

    //การหา100เมนูจากโมเดล
    function get_recFoodNewUser($user_id)
    {
        $user_recommended_count = Food_recommended::where('user_id', $user_id)->latest()->count();
        if ($user_recommended_count == 0) {


            $food_arr = '[';
            //len - 1 เพื่อแก้ , (มีทั้งหมด 350)
            for ($i = 0; $i < 349; $i++) {
                $food_arr = $food_arr . ($i + 1) . ',';
            }
            $food_arr = $food_arr . '350]';

            //user ใหม่ใช้ id = 0
            $new_user_id = 0;
            $user_arr = '[';
            //len - 1 เพื่อแก้ , (มีทั้งหมด 350)
            for ($i = 0; $i < 349; $i++) {
                $user_arr = $user_arr . $new_user_id . ',';
            }
            $user_arr = $user_arr . $new_user_id . ']';

            $body = '{"instances":[{"input_1":' . $food_arr . ' ,"input_2":' . $user_arr . ' }]}';
            $response = Http::withBody($body, 'text/plain')->post('http://localhost:8605/v1/models/recomm:predict');
            // // var_dump(json_decode($response));

            $data = json_decode($response);
            $array = $data->predictions;
            $foodResponse = [];
            for ($i = 0; $i < count($array); $i++) {
                $floor_1 = $array[$i];
                $foodResponse[] = $floor_1[0];
            }

            //เรียงลำดับ
            arsort($foodResponse);
            $loopCount = 0;
            foreach ($foodResponse as $key => $value) {
                $foodrec = new Food_recommended([
                    'user_id' => $user_id,
                    'food_id' => $key + 1,
                    'score_nutrition' => 0,
                    'score_sum' => 1,
                    'igd_matching' => 0,
                ]);
                $foodrec->save();
                $loopCount++;
                //กำหนดจำนวนเมนูที่ต้องการ
                if ($loopCount > 99) {
                    $loopCount = 0;
                    break;
                }
            }
        } else {
        }
    }


    function add_history(Request $request)
    {
        $user_id = $request->get('user_id');
        $food_id = $request->get('food_id');
        $history = new Eating_history([
            'user_id' => $user_id,
            'food_id' => $food_id,
        ]);
        $history->save();
        return response('บันทึกประวัติการรับประทานแล้ว');
    }













    function get_noRat()
    {
        $food = Food::latest()->get();
        $foodNoRat = [];
        foreach ($food as $key => $value) {
            $foodRec = Food_rating::where('food_id', $value->food_id)->latest()->count();
            if ($foodRec == 0) {
                $foodNoRat[] = $value->food_id;
            }
        }
        asort($foodNoRat);
        dd($foodNoRat);
    }
}
