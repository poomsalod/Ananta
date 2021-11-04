<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category_igd;
use App\Models\Igd_info;

class Cate_igdController extends Controller
{
    public function show_Igd_info_cate(){
        $cate_igd = Category_igd::latest()->paginate();
        $count = $cate_igd->count();
        return view('Igd_info.Cate_igd_index', compact('cate_igd', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function show_addIgd_info_cate()
    {
        return view('Igd_info.Cate_igd_add');
    }

    public function addIgd_info_cate(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:category_igd',
        ], [
            'name.required' => "กรุณาป้อนชื่อประเภทวัตถุดิบ",
            'name.unique' => "ชื่อนี้ถูกใช้แล้ว",   
        ]);

        $cate_igd = new Category_igd([
            'name' => $request->get('name'),
            'admin_id' => Auth::user()->account_id
        ]);
        $cate_igd->save();
        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย')->with('backpageUrl', $request->get('backpageUrl'));
    }

    public function show_editIgd_info_cate($id)
    {
        $cate_igd = Category_igd::find($id);
        return view('Igd_info.Cate_igd_edit', compact('id', 'cate_igd'));
    }

    public function editIgd_info_cate(Request $request)
    {
        $cate_igd = Category_igd::find($request->get('id'));
        $request->validate([
            'name' => 'required|unique:category_igd,name,' . $cate_igd->name . ',name',
        ], [
            'name.required' => "กรุณาป้อนชื่อวัตถุดิบ",
            'name.unique' => "ชื่อนี้ถูกใช้แล้ว", 
        ]);
        $cate_igd->name = $request->get('name');
        $cate_igd->admin_id = Auth::user()->account_id;
        $cate_igd->save();
        return redirect()->back()->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

    public function desIgd_info_cate($id)
    {
        $cate_igd = Category_igd::find($id);
        $igd_info = Igd_info::where('cate_igd_id',  $id)->latest()->paginate(10);
        $count = $igd_info->count();
        if($count == 0){
            $cate_igd->delete();
            $success = "ลบข้อมูลเรียบร้อย";
        }else{
            $success = 1;
        }
        
        return redirect()->back()->with('success', $success);
    }
}
