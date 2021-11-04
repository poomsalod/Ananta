<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category_food;
use App\Models\Food;

class Cate_foodController extends Controller
{
    public function show_Food_cate(){
        $cate_food = Category_food::latest()->paginate();
        $count = $cate_food->count();
        return view('Food.Cate_food_index', compact('cate_food', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function show_addFood_cate()
    {
        return view('Food.Cate_food_add');
    }

    public function addFood_cate(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:category_food',
        ], [
            'name.required' => "กรุณาป้อนชื่อประเภทวัตถุดิบ",
            'name.unique' => "ชื่อนี้ถูกใช้แล้ว",   
        ]);

        $cate_food = new Category_food([
            'name' => $request->get('name'),
            'admin_id' => Auth::user()->account_id
        ]);
        $cate_food->save();
        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย')->with('backpageUrl', $request->get('backpageUrl'));
    }

    public function show_editFood_cate($id)
    {
        $cate_food = Category_food::find($id);
        return view('Food.Cate_food_edit', compact('id', 'cate_food'));
    }

    public function editFood_cate(Request $request)
    {
        $cate_food = Category_food::find($request->get('id'));
        $request->validate([
            'name' => 'required|unique:category_food,name,' . $cate_food->name . ',name',
        ], [
            'name.required' => "กรุณาป้อนชื่อวัตถุดิบ",
            'name.unique' => "ชื่อนี้ถูกใช้แล้ว", 
        ]);
        $cate_food->name = $request->get('name');
        $cate_food->admin_id = Auth::user()->account_id;
        $cate_food->save();
        return redirect()->back()->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

    public function desFood_cate($id)
    {
        $cate_food = Category_food::find($id);
        $food = Food::where('cate_food_id',  $id)->latest()->paginate(10);
        $count = $food->count();
        if($count == 0){
            $cate_food->delete();
            $success = "ลบข้อมูลเรียบร้อย";
        }else{
            $success = 1;
        }
        
        return redirect()->back()->with('success', $success);
    }
}
