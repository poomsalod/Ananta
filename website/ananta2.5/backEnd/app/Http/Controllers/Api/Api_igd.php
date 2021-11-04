<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category_igd;
use App\Models\Food_allergy;
use App\Models\Igd_info;
use Illuminate\Http\Request;

class Api_igd extends Controller
{
    //
    function get_igdForAllergy(Request $request)
    {
        $user_id = $request->get('user_id');
        $igd = Igd_info::get()->all();
        $listIgd = [];
        foreach ($igd as $key => $value) {
            $countFoodAllergy = Food_allergy::where('user_id', $user_id)->where('igd_info_id', $value->igd_info_id)->count();
            if ($countFoodAllergy == 0) {
                $listIgd[] = $value;
            }
        }

        $jsonigd = [];
        foreach ($listIgd as $key => $value) {
            $json = [
                "igd_info_id" => $value->igd_info_id,
                "name" => $value->name,
                "image" => $value->image,
                "cate_igd_id" => $value->cate_igd_id,
            ];
            $jsonigd[] = $json;
        }
        $response = json_encode($jsonigd, JSON_UNESCAPED_UNICODE);

        return response($response);
    }

    function addFoodAllergy(Request $request)
    {
        $checkorder = Food_allergy::where('igd_info_id', $request->get('igd_info_id'))->where('user_id', $request->get('user_id'))->latest()->count();


        if ($checkorder != 0) {
        } else {

            $igd_info = new Food_allergy([
                'user_id' => $request->get('user_id'),
                'igd_info_id' => $request->get('igd_info_id'),
            ]);

            $igd_info->save();
        }
    }

    function getCateIgd()
    {
        $cate = Category_igd::orderBy('name')->get();

        $jsonfood = [];
        foreach ($cate as $key => $value) {
            $json = [
                "cate_igd_id" => $value->cate_igd_id,
                "name" => $value->name,
            ];
            $jsonfood[] = $json;
        }
        $response = json_encode($jsonfood, JSON_UNESCAPED_UNICODE);

        return response($response);
    }

    function get_FoodAllergy(Request $request)
    {
        $user_id = $request->get('user_id');
        $foodAllergy = Food_allergy::where('user_id', $user_id)->latest();
        $count = $foodAllergy->count();
        $foodAllergy = $foodAllergy->get();

        $listIgd = [];
        if ($count != 0) {
            foreach ($foodAllergy as $key => $value) {
                $igd = Igd_info::find($value->igd_info_id);
                $listIgd[] = $igd;
            }
        }
        $jsonigd = [];
        if (count($listIgd) != 0) {
            foreach ($listIgd as $key => $value) {
                $json = [
                    "igd_info_id" => $value->igd_info_id,
                    "name" => $value->name,
                    "image" => $value->image,
                    "cate_igd_id" => $value->cate_igd_id,
                ];
                $jsonigd[] = $json;
            }
        }
        $response = json_encode($jsonigd, JSON_UNESCAPED_UNICODE);

        return response($response);
    }

    public function deIgd(Request $request)
    {
        $food_ag = Food_allergy::where('user_id',$request->get('user_id'))->where('igd_info_id',$request->get('igd_info_id'))->get();
        $food_ag[0]->delete();

    }
}
