<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Food;
use App\Models\Category_food;
use App\Models\Igd_of_food;
use App\Models\Category_igd;
use App\Models\Igd_info;
use App\Models\Step_of_food;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

use Illuminate\Http\Request;

class FoodController extends Controller
{
    //แสดงหน้าแรก
    public function index()
    {
        $cate_food = Category_food::orderBy('name')->get();
        $food = Food::latest();
        $count = $food->count();
        $food = $food->paginate(10);

        return view('Food.Food_index', compact('food', 'cate_food', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    //การค้นหาเมนู
    public function search(Request $request)
    {
        $cate_food = Category_food::orderBy('name')->get();

        if ($request->get('category') == 0) {

            //ค้นหาจากชื่อ จากทั้งหมด
            if ($request->get('search') != null) {
                $search = $request->get('search');
                $food = Food::Where('name', 'like', '%' . $search . '%')->latest();
            }
            //ค้นหาทั้งหมด
            else {
                $food = Food::latest();
            }
        } else {
            //ค้นหาจากชื่อ จากประเภท
            if ($request->get('search') != null) {
                $search = $request->get('search');
                $food = Food::Where('name', 'like', '%' . $search . '%')->where('cate_food_id', $request->get('category'))->latest();
            }
            //ค้นหาจากประเภท
            else {
                $food = Food::Where('cate_food_id', $request->get('category'))->latest();
            }
        }

        $count = $food->count();
        $food = $food->paginate(10);
        $food->appends($request->all()); //เป็นเพิ่ม $request ใน url ไม่งั้นบัค
        return view('Food.Food_index', compact('food', 'cate_food', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    //แสดงหน้าเพิ่มเมนู
    public function show_addFood()
    {
        $cate_food = Category_food::orderBy('name')->get();
        return view('Food.Food_add', compact('cate_food'));
    }

    //การเพิ่มเมนู
    public function addFood(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:food',
            'img' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category' => 'required|integer',
            'addess' => 'required|max:1000',
        ], [
            'name.required' => "กรุณาป้อนชื่อเมนู",
            'name.unique' => "ชื่อนี้ถูกใช้แล้ว",
            'category.required' => "กรุณาเลือกประเภทเมนู",
            'category.integer' => "กรุณาเลือกประเภทเมนู",
            'addess.required' => "กรุณาป้อนที่มาของข้อมูล",
            'img.required' => "กรุณาอัพโหลดรูปภาพเมนู",
            'img.mimes' => "รูปภาพต้องเป็นไฟล์ jpeg,png,jpg,webp",
            'img.max' => "รูปภาพต้องมีขนาดไม่เกิน 2 Mb",
            'img.image' => "กรุณาเลือกไฟล์ที่เป็นรูปภาพ",

        ]);


        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            // $request->img->storeAs('images/igd', $new_name, 'public');

            $img = Image::make($image->path());
            $img->resize(400, 400, function ($const) {
                $const->aspectRatio();
            })->save(storage_path() . '/app/public/images/food/' . $new_name);
        }


        $food = new Food([
            'name' => $request->get('name'),
            'image' => $new_name,
            'cate_food_id' => $request->get('category'),
            'calorie' => 0,
            'carbohydrate' => 0,
            'protein' => 0,
            'fat' => 0,
            'fiber' => 0,
            'addess' => $request->get('addess'),
            'admin_id' => Auth::user()->account_id,
            'status' => 1
        ]);
        $food->save();
        // return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย')->with('backpageUrl', $request->get('backpageUrl'));
        return redirect()->route('show_food', [$food->food_id])->with('success', 'บันทึกข้อมูลเรียบร้อย');
        // return redirect()->route('show_food', '50')->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    // แสดงหน้าข้อมูลเมนู
    public function show($id)
    {
        $food = Food::find($id);
        $category_food = Category_food::orderBy('name')->get();

        $iof = Igd_of_food::with("igd_info.cate_igd")->where('food_id', $id)->latest();
        $count_iof = $iof->count();
        $iof = $iof->paginate(10);

        $step = Step_of_food::where('food_id',  $id)->orderBy('order')->latest();
        $count_step = $step->count();
        $step = $step->paginate(10);
        return view('Food.Food_show', compact('food', 'category_food', 'iof', 'count_iof', 'step', 'count_step'))->with('i', 0);
    }

    //แสดงหน้าแก้ไขวัตถุดิบ
    public function show_editFood($id)
    {
        $food = Food::find($id);
        $cate_food = Category_food::orderBy('name')->get();
        return view('Food.Food_edit', compact('food', 'cate_food'));
    }

    //การแก้ไขวัตถุดิบ
    public function editFood(Request $request)
    {
        $food = Food::find($request->get('id'));
        $request->validate([
            'name' => 'required|unique:food,name,' . $food->name . ',name',
            'category' => 'required|integer',
            'addess' => 'required|max:1000',
        ], [
            'name.required' => "กรุณาป้อนชื่อวัตถุดิบ",
            'name.unique' => "ชื่อนี้ถูกใช้แล้ว",
            'category.required' => "กรุณาเลือกประเภทวัตถุดิบ",
            'category.integer' => "กรุณาเลือกประเภทวัตถุดิบ",
            'addess.required' => "กรุณาป้อนที่มาของข้อมูล",
        ]);

        //ถ้าใช้รูปใหม่
        if ($request->hasFile('img')) {
            $request->validate([
                'img' => 'required|image|mimes:jpeg,png,jpg,webp|max:1024',
            ], [
                'img.required' => "กรุณาอัพโหลดรูปภาพวัตถุดิบ",
                'img.mimes' => "รูปภาพต้องเป็นไฟล์ jpeg,png,jpg,webp",
                'img.max' => "รูปภาพต้องมีขนาดไม่เกิน 1 Mb",
                'img.image' => "กรุณาเลือกไฟล์ที่เป็นรูปภาพ",
            ]);
            $image = $request->file('img');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            Storage::delete('/public/images/food/' . $food->image);

            $img = Image::make($image->path());
            $img->resize(400, 400, function ($const) {
                $const->aspectRatio();
            })->save(storage_path() . '/app/public/images/food/' . $new_name);

            $food->image = $new_name;
        }

        $food->name = $request->get('name');
        $food->cate_food_id = $request->get('category');
        $food->addess = $request->get('addess');
        $food->admin_id = Auth::user()->account_id;
        $food->save();
        return redirect()->back()->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

    //แสดงหน้าเพิ่มวัตถุดิบในเมนู
    public function show_addigd($id)
    {
        $food = Food::find($id);
        $cate_igd = Category_igd::all();
        $igd_info = Igd_info::latest();
        $count = $igd_info->count();
        $igd_info = $igd_info->paginate(3);
        return view('Food.Food_show_addigd', compact('igd_info', 'cate_igd', 'count', 'food'))->with('i', (request()->input('page', 1) - 1) * 3);
    }

    //การค้นหาวัตถุดิบ
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

        $food = Food::find($request->get('id'));
        $count = $igd_info->count();
        $igd_info = $igd_info->paginate(3);
        $igd_info->appends($request->all()); //เป็นเพิ่ม $request ใน url ไม่งั้นบัค
        return view('Food.Food_show_addigd', compact('igd_info', 'cate_igd', 'count', 'food'))->with('i', (request()->input('page', 1) - 1) * 3);
    }

    public function show_add_detail_igd($food_id, $igd_id)
    {
        $food_id = $food_id;
        $igd = Igd_info::find($igd_id);
        return view('Food.Food_show_add_detail_igd', compact('igd', 'food_id'));
    }

    //การเพิ่มวัตถุดิบในเมนู
    public function addigd(Request $request)
    {
        $des = '';
        $unit = 'อื่นๆ';
        if ($request->get('radio1') == 'Enable') {
            $request->validate([
                'food_id' => 'required',
                'igd_info_id' => 'required',
                'value' => 'required|numeric|min:0.0001',
                'unit1' => 'required',
            ], [
                'value.min' => 'กรุณาระบุจำนวน',
                'unit1.required' => 'กรุณาระบุหน่วย',
            ]);
        } else {
            $request->validate([
                'food_id' => 'required',
                'igd_info_id' => 'required',
            ]);
        }

        $des = $des . $request->get('des');
        $unit = $request->get('unit1');
        $checkorder = 0;
        $iof = Igd_of_food::where('food_id', $request->get('food_id'))->get();
        foreach ($iof as $key => $value) {
            if ($value->igd_info_id == $request->get('igd_info_id')) {
                $checkorder = 1;
            }
        }

        if ($checkorder == 1) {
            return redirect()->back()->with('error', 'ไม่สามารถเลือกวัตถุดิบซ้ำได้');
        } else {
            if ($unit == 'อื่นๆ' || $request->get('radio1') == 'Disable') {
                $iof = new Igd_of_food([
                    'food_id' => $request->get('food_id'),
                    'igd_info_id' => $request->get('igd_info_id'),
                    'description' => $des,
                    'value' => $request->get('value'),
                    'unit' => '',
                    'importance' => false,
                    'admin_id' => Auth::user()->account_id
                ]);
            } else {
                $iof = new Igd_of_food([
                    'food_id' => $request->get('food_id'),
                    'igd_info_id' => $request->get('igd_info_id'),
                    'description' => $des,
                    'value' => $request->get('value'),
                    'unit' => $request->get('unit1'),
                    'importance' => true,
                    'admin_id' => Auth::user()->account_id
                ]);
            }
            $iof->save();
            $this->calfood($request->get('food_id'));

            return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
        }
    }

    public function show_edit_detail_igd($iof_id)
    {
        $iof = Igd_of_food::find($iof_id);
        return view('Food.Food_show_edit_detail_igd', compact('iof'));
    }

    //การแก้ไขวัตถุดิบในเมนู
    public function updateIgd(Request $request)
    {
        $des = '';
        $unit = 'อื่นๆ';
        if ($request->get('radio1') == 'Enable') {
            $request->validate([
                'value' => 'required|numeric|min:0.0001',
                'unit1' => 'required',
            ], [
                'value.required' => 'กรุณาระบุจำนวน',
                'value.min' => 'จำนวนต้องมากกว่า 0 ขึ้นไป',
                'unit1.required' => 'กรุณาระบุหน่วย',
            ]);
        } 

        $des = $des . $request->get('des');
        $unit = $request->get('unit1');

        $iof = Igd_of_food::find($request->get('iof_id'));
        if ($unit == 'อื่นๆ' || $request->get('radio1') == 'Disable') {
            $iof->description = $des;
            $iof->value = $request->get('value');
            $iof->unit = '';
            $iof->importance = false;
            $iof->admin_id = Auth::user()->account_id;

        } else {
            $iof->description = $des;
            $iof->value = $request->get('value');
            $iof->unit = $request->get('unit1');
            $iof->importance = true;
            $iof->admin_id = Auth::user()->account_id;
        }
        
        $iof->save();
        $this->calfood($iof->food_id);

        return redirect()->back()->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

    //การพลังงานในเมนูจากวัตถุดิบ
    public function calfood($id)
    {

        $food = Food::find($id);
        $iof = Igd_of_food::where('food_id', $id)->where('importance',  1)->get();

        $cal = 0;
        $fat = 0;
        $pro = 0;
        $car = 0;
        $fib = 0;

        foreach ($iof as $key => $value) {
            if ($value->unit == 'ช้อนชา') {
                $result = 5;
            } elseif ($value->unit == 'ช้อนโต๊ะ') {
                $result = 15;
            } elseif ($value->unit == 'ถ้วยตวง') {
                $result = 240;
            } else {
                $result = 1;
            }
            $cal = $cal + ($value->value * $result * $value->igd_info->calorie);
            $fat = $fat + ($value->value * $result * $value->igd_info->fat);
            $pro = $pro + ($value->value * $result * $value->igd_info->protein);
            $car = $car + ($value->value * $result * $value->igd_info->carbohydrate);
            $fib = $fib + ($value->value * $result * $value->igd_info->fiber);
        }

        $food->calorie = $cal;
        $food->fat = $fat;
        $food->protein = $pro;
        $food->carbohydrate = $car;
        $food->fiber = $fib;
        $food->save();
    }

    public function calallfood()
    {
        $food = Food::where('calorie', "<", 800)->latest()->count();
        dd($food);
        // $food = Food::latest()->get();
        // // dd($food);
        // foreach ($food as $key => $value1) {
        //     $iof = Igd_of_food::where('food_id', $value1->food_id)->where('importance',  1)->get();

        //     $cal = 0;
        //     $fat = 0;
        //     $pro = 0;
        //     $car = 0;
        //     $fib = 0;

        //     foreach ($iof as $key => $value) {
        //         if ($value->unit == 'ช้อนชา') {
        //             $result = 5;
        //         } elseif ($value->unit == 'ช้อนโต๊ะ') {
        //             $result = 15;
        //         } elseif ($value->unit == 'ถ้วยตวง') {
        //             $result = 240;
        //         } else {
        //             $result = 1;
        //         }

        //         $cal = $cal + ($value->value * $result * $value->igd_info->calorie);
        //         $fat = $fat + ($value->value * $result * $value->igd_info->fat);
        //         $pro = $pro + ($value->value * $result * $value->igd_info->protein);
        //         $car = $car + ($value->value * $result * $value->igd_info->carbohydrate);
        //         $fib = $fib + ($value->value * $result * $value->igd_info->fiber);
        //     }

        //     $value1->calorie = $cal;
        //     $value1->fat = $fat;
        //     $value1->protein = $pro;
        //     $value1->carbohydrate = $car;
        //     $value1->fiber = $fib;
        //     $value1->save();
        // }
        // echo "successssss";
    }

    public function deIgd($id)
    {
        $iof = Igd_of_food::find($id);
        $food_id = $iof->food_id;
        $iof->delete();

        $this->calfood($food_id);
        return redirect()->back()->with('success', 'ลบข้อมูลเรียบร้อย');
    }

    public function show_addstep($id)
    {
        $step = Step_of_food::where('food_id', $id)->latest()->count();
        $step = $step + 1;
        $food = Food::find($id);
        return view('Food.Food_show_addstep', compact('food', 'step'));
    }

    public function addstep(Request $request)
    {
        // dd($request->get('step2'));
        $request->validate([
            'order' => 'required',
            'step' => 'required|max:1200'
        ], [
            'order.required' => 'กรุณาระบุลำดับขั้นตอน',
            'step.required' => 'กรุณาระบุรายละเอียดวิธีทำ',
            'step.max' => 'ตัวอักษรสูงสุด 1200 ตัว',
        ]);
        $checkorder = 0;
        $steps = Step_of_food::where('food_id', $request->get('food_id'))->get();
        foreach ($steps as $key => $value) {
            if ($value->order == $request->get('order')) {
                $checkorder = 1;
            }
        }

        if ($checkorder == 1) {
            return redirect()->back()->with('error', 'ลำดับขั้นตอนซ้ำ');
        } else {
            $step = new Step_of_food([
                'food_id' => $request->get('food_id'),
                'order' => $request->get('order'),
                'step' => $request->get('step'),
                'admin_id' => Auth::user()->account_id
            ]);
            // dd($step);
            $step->save();
            return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
        }
    }

    public function show_editstep($id)
    {
        $step = Step_of_food::find($id);
        return view('Food.Food_show_editstep', compact('step'));
    }

    public function updateStep(Request $request)
    {

        $request->validate([
            'step' => 'required|max:1200'
        ], [
            'step.required' => 'กรุณาระบุรายละเอียดวิธีทำ',
            'step.max' => 'ตัวอักษรสูงสุด 1200 ตัว',
        ]);
        $step = Step_of_food::find($request->get('sof_id'));
        $step->step = $request->get('step');
        $step->save();
        return redirect()->back()->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

    public function deStep($id)
    {
        $step = Step_of_food::find($id);
        $step->delete();

        return redirect()->back()->with('success', 'ลบข้อมูลเรียบร้อย');
    }


    public function test()
    {
        $iof = Igd_of_food::with("igd_info.cate_igd")->where('food_id', 1)->get();
        //$iof = Igd_of_food::with("igd_info.cate_igd")->get()->all();
        dd($iof);
    }
}
