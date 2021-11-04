<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Igd_info;
use App\Models\Category_igd;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


class Igd_infoController extends Controller
{
    //แสดงหน้าแรก
    public function index()
    {
        $cate_igd = Category_igd::orderBy('name')->get();
        $igd_info = Igd_info::latest();
        $count = $igd_info->count();
        $igd_info = $igd_info->paginate(10);
        return view('Igd_info.Igd_info_index', compact('igd_info', 'cate_igd', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    //การค้นหาวัตถุดิบ
    public function search(Request $request)
    {
        $cate_igd = Category_igd::orderBy('name')->get();

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
        $igd_info->appends($request->all());//เป็นเพิ่ม $request ใน url ไม่งั้นบัค
        return view('Igd_info.Igd_info_index', compact('igd_info', 'cate_igd', 'count'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    //แสดงหน้าเพิ่มวัตถุดิบ
    public function show_addIgd_info()
    {
        $cate_igd = Category_igd::orderBy('name')->get();
        return view('Igd_info.Igd_info_add', compact('cate_igd'));
    }

    //การเพิ่มวัตถุดิบ
    public function addIgd_info(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:igd_info',
            'img' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'pro' => 'required',
            'car' => 'required',
            'fat' => 'required',
            'fib' => 'required',
            'cal' => 'required',
            'category' => 'required|integer',
            'addess' => 'required|max:1000',
            'addess_img' => 'required|max:1000',
        ], [
            'name.required' => "กรุณาป้อนชื่อวัตถุดิบ",
            'name.unique' => "ชื่อนี้ถูกใช้แล้ว",
            'pro.required' => "กรุณาป้อนค่าโปรตีน",
            'car.required' => "กรุณาป้อนค่าคาร์โบไฮเดรต",
            'fat.required' => "กรุณาป้อนค่าไขมัน",
            'fib.required' => "กรุณาป้อนค่าใยอาหาร",
            'cal.required' => "กรุณาป้อนค่าแคลอรี่",
            'category.required' => "กรุณาเลือกประเภทวัตถุดิบ",
            'category.integer' => "กรุณาเลือกประเภทวัตถุดิบ",
            'addess.required' => "กรุณาป้อนที่มาของข้อมูล",
            'addess_img.required' => "กรุณาป้อนที่มาของรูปภาพ",
            'img.required' => "กรุณาอัพโหลดรูปภาพวัตถุดิบ",
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
            })->save(storage_path() . '/app/public/images/igd/' . $new_name);

        }


        $igd_info = new Igd_info([
            'name' => $request->get('name'),
            'image' => $new_name,
            'cate_igd_id' => $request->get('category'),
            'calorie' => $request->get('cal'),
            'carbohydrate' => $request->get('car'),
            'protein' => $request->get('pro'),
            'fat' => $request->get('fat'),
            'fiber' => $request->get('fib'),
            'addess' => $request->get('addess'),
            'addess_img' => $request->get('addess_img'),
            'admin_id' => Auth::user()->account_id
        ]);
        $igd_info->save();
        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย')->with('backpageUrl', $request->get('backpageUrl'));
    }

    //แสดงหน้าแก้ไขวัตถุดิบ
    public function show_editIgd_info($id)
    {
        $igd_info = Igd_info::find($id);
        $cate_igd = Category_igd::orderBy('name')->get();
        return view('Igd_info.Igd_info_edit', compact('igd_info', 'id', 'cate_igd'));
    }

    //การแก้ไขวัตถุดิบ
    public function editIgd_info(Request $request)
    {
        $igd_info = Igd_info::find($request->get('id'));
        $request->validate([
            'name' => 'required|unique:igd_info,name,' . $igd_info->name . ',name',
            'pro' => 'required',
            'car' => 'required',
            'fat' => 'required',
            'fib' => 'required',
            'cal' => 'required',
            'category' => 'required|integer',
            'addess' => 'required|max:1000',
            'addess_img' => 'required|max:1000',
        ], [
            'name.required' => "กรุณาป้อนชื่อวัตถุดิบ",
            'name.unique' => "ชื่อนี้ถูกใช้แล้ว",
            'pro.required' => "กรุณาป้อนค่าโปรตีน",
            'car.required' => "กรุณาป้อนค่าคาร์โบไฮเดรต",
            'fat.required' => "กรุณาป้อนค่าไขมัน",
            'fib.required' => "กรุณาป้อนค่าใยอาหาร",
            'cal.required' => "กรุณาป้อนค่าแคลอรี่",
            'category.required' => "กรุณาเลือกประเภทวัตถุดิบ",
            'category.integer' => "กรุณาเลือกประเภทวัตถุดิบ",
            'addess.required' => "กรุณาป้อนที่มาของข้อมูล",
            'addess_img.required' => "กรุณาป้อนที่มาของรูปภาพ",
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
            Storage::delete('/public/images/igd/' . $igd_info->image);
            //$request->img->storeAs('images/igd', $new_name, 'public');

            $img = Image::make($image->path());
            $img->resize(400, 400, function ($const) {
                $const->aspectRatio();
            })->save(storage_path() . '/app/public/images/igd/' . $new_name);

            $igd_info->image = $new_name;
        }

        $igd_info->name = $request->get('name');
        $igd_info->cate_igd_id = $request->get('category');
        $igd_info->calorie = $request->get('cal');
        $igd_info->carbohydrate = $request->get('car');
        $igd_info->protein = $request->get('pro');
        $igd_info->fat = $request->get('fat');
        $igd_info->fiber = $request->get('fib');
        $igd_info->addess = $request->get('addess');
        $igd_info->addess_img = $request->get('addess_img');
        $igd_info->admin_id = Auth::user()->account_id;
        $igd_info->save();
        return redirect()->back()->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

    //การลบวัตถุดิบ สำหรับ Test
    public function destroy($id)
    {
        $igd_info = Igd_info::find($id);
        $igd_info->delete();
        return redirect()->back()->with('success', 'ลบข้อมูลเรียบร้อย');
    }
}
