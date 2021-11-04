<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category_food;
use Illuminate\Http\Request;


class Api_cate extends Controller
{
    function getCateFood(){
        $cate = Category_food::orderBy('name')->get();

        $jsonfood = [];
        foreach ($cate as $key => $value) {
            $json = [
                "cate_food_id" => $value->cate_food_id,
                "name" => $value->name,
            ];
            $jsonfood[] = $json;
        }
        $response = json_encode($jsonfood, JSON_UNESCAPED_UNICODE);

        return response($response);
    }
}
