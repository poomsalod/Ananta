<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Igd_info;
use App\Models\stock_igd;
use Illuminate\Http\Request;

class Api_stock extends Controller
{
    function get_igdForStock(Request $request)
    {
        $user_id = $request->get('user_id');
        $igd = Igd_info::get()->all();
        $listIgd = [];
        foreach ($igd as $key => $value) {
            $countFoodAllergy = stock_igd::where('user_id', $user_id)->where('igd_info_id', $value->igd_info_id)->count();
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

    public function addStock(Request $request)
    {

        $checkorder = stock_igd::where('igd_info_id', $request->get('igd_info_id'))->where('user_id', $request->get('user_id'))->latest()->count();

        if ($checkorder == 0) {
            $igd_info = new stock_igd([
                'user_id' => $request->get('user_id'),
                'igd_info_id' => $request->get('igd_info_id'),
                'value' => $request->get('value'),
            ]);

            $igd_info->save();
        }
    }

    function getStock(Request $request)
    {
        $user_id = $request->get('user_id');
        $stock = stock_igd::where('user_id', $user_id)->latest();
        $count = $stock->count();
        $stock = $stock->get();

        $jsonigd = [];
        if ($count != 0) {
            foreach ($stock as $key => $value) {
                $json = [
                    "igd_info_id" => $value->igd_info_id,
                    "name" => $value->igd_info->name,
                    "image" => $value->igd_info->image,
                    "cate_igd_id" => $value->igd_info->cate_igd_id,
                    "value" => $value->value,
                ];
                $jsonigd[] = $json;
            }
        }

        $response = json_encode($jsonigd, JSON_UNESCAPED_UNICODE);

        return response($response);
    }

    public function deStock(Request $request)
    {
        $food_ag = stock_igd::where('user_id',$request->get('user_id'))->where('igd_info_id',$request->get('igd_info_id'))->get();

        // dd($food_ag);
        $food_ag[0]->delete();

    }
}
