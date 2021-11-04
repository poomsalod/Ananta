<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\stock_igd;
use App\Models\Category_igd;
use App\Models\Igd_info;
use Illuminate\Support\Facades\Auth;

class Stock_igd_Controller extends Controller
{
    function index()
    {
        $stock_igd = stock_igd::where('user_id', Auth::user()->user_profile->user_id)->latest();
        $count = $stock_igd->count();
        $stock_igd = $stock_igd->paginate(10);
        return view('Users.igd_stock.User_igd_stock_index', compact('stock_igd', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    function show_add()
    {
        $cate_igd = Category_igd::all();
        $igd_info = Igd_info::latest();
        $count = $igd_info->count();
        $igd_info = $igd_info->paginate(10);
        return view('Users.igd_stock.User_igd_stock_add', compact('igd_info', 'cate_igd', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function addigd(Request $request)
    {

        $request->validate([
            'igd_info_id' => 'required',
            'value' => 'required',
        ]);


        $checkorder = stock_igd::where('igd_info_id', $request->get('igd_info_id'))->where('user_id', Auth::user()->user_profile->user_id)->latest()->count();


        if ($checkorder != 0) {
            return redirect()->back()->with('error', 'ไม่สามารถเลือกวัตถุดิบซ้ำได้');
        } else {

            $igd_info = new stock_igd([
                'user_id' => Auth::user()->user_profile->user_id,
                'igd_info_id' => $request->get('igd_info_id'),
                'value' => $request->get('value'),
            ]);

            $igd_info->save();
            return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
        }
    }

    public function deIgd($id)
    {
        $food_ag = stock_igd::find($id);

        // dd($food_ag);
        $food_ag->delete();

        return redirect()->back()->with('success', 'ลบข้อมูลเรียบร้อย');
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
        return view('Users.igd_stock.User_igd_stock_add', compact('igd_info', 'cate_igd', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    function show_edit($id)
    {
        $igd_stock = stock_igd::find($id);
        return view('Users.igd_stock.User_igd_stock_edit', compact('igd_stock', 'id'));
    }

    function edit_data(Request $request)
    {
        $request->validate([
            'value' => ['required'],
        ]);

        $IgdStock = stock_igd::find($request->get('id'));
        $IgdStock->value = $request->get('value');
        
        $IgdStock->save();
        return redirect()->back()->with('success', 'เรียบร้อย');

    }

}
