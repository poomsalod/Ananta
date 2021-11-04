<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Igd_info;
use App\Models\Category_igd;
use App\Models\Food_allergy;
use Illuminate\Support\Facades\Auth;

class Food_allergyController extends Controller
{
    function index()
    {
        $food_ag = Food_allergy::where('user_id', Auth::user()->user_profile->user_id)->latest();
        $count = $food_ag->count();
        $food_ag = $food_ag->paginate(10);
        return view('Users.Food_allergy.User_food_allergy_index', compact('food_ag', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    function show_add()
    {
        $cate_igd = Category_igd::all();
        $igd_info = Igd_info::latest();
        $count = $igd_info->count();
        $igd_info = $igd_info->paginate(10);
        return view('Users.Food_allergy.User_food_allergy_add', compact('igd_info', 'cate_igd', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function search_igd(Request $request)
    {
        $cate_igd = Category_igd::all();

        if ($request->get('category') == 0) {

            //ค้นหาจากชื่อ จากทั้งหมด
            if ($request->get('search') != null) {
                $search = $request->get('search');
                $igd_info = Igd_info::Where('name', 'like', '%' . $search . '%')->latest();
            }
            //ค้นหาทั้งหมด
            else {
                $igd_info = Igd_info::latest();
            }
        } else {
            //ค้นหาจากชื่อ จากประเภท
            if ($request->get('search') != null) {
                $search = $request->get('search');
                $igd_info = Igd_info::Where('name', 'like', '%' . $search . '%')->where('cate_igd_id', $request->get('category'))->latest();
            }
            //ค้นหาจากประเภท
            else {
                $igd_info = Igd_info::Where('cate_igd_id', $request->get('category'))->latest();
            }
        }

        $count = $igd_info->count();
        $igd_info = $igd_info->paginate(10);
        $igd_info->appends($request->all()); //เป็นเพิ่ม $request ใน url ไม่งั้นบัค
        return view('Users.Food_allergy.User_food_allergy_add', compact('igd_info', 'cate_igd', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }


    public function addigd(Request $request)
    {

        $request->validate([
            'igd_info_id' => 'required',
        ]);


        $checkorder = Food_allergy::where('igd_info_id', $request->get('igd_info_id'))->where('user_id', Auth::user()->user_profile->user_id)->latest()->count();


        if ($checkorder != 0) {
            return redirect()->back()->with('error', 'ไม่สามารถเลือกวัตถุดิบซ้ำได้');
        } else {

            $igd_info = new Food_allergy([
                'user_id' => Auth::user()->user_profile->user_id,
                'igd_info_id' => $request->get('igd_info_id'),
            ]);

            $igd_info->save();
            return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
        }
    }

    public function deIgd($id)
    {
        $food_ag = Food_allergy::find($id);

        // dd($food_ag);
        $food_ag->delete();

        return redirect()->back()->with('success', 'ลบข้อมูลเรียบร้อย');
    }

    function show_edit($id)
    {
        $food_allergy = Food_allergy::find($id);
        $cate_igd = Category_igd::all();
        $igd_info = Igd_info::latest();
        $count = $igd_info->count();
        $igd_info = $igd_info->paginate(10);
        return view('Users.Food_allergy.User_food_allergy_edit', compact('igd_info', 'food_allergy', 'cate_igd', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function edit_addigd(Request $request)

    {
        // dd($request);
        $request->validate([
            'igd_info_id' => ['required'],
        ]);

        $igd_allergy = Food_allergy::find($request->get('food_allergy'));
        $igd_allergy->igd_info_id = $request->get('igd_info_id');
        
        $igd_allergy->save();
        return redirect()->back()->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }
}
