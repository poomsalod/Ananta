<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $admins = Admin::first()->paginate(5);
        // return view('admin.admin_index' , compact('admins'))->with('i' , (request()->input('page', 1) -1) *5);

        // จาก loginsystem
        return view('Food.Food_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admin_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        ['fname' => 'required', 
        'lname' => 'required', 
        'user' => 'required', 
        'pass' => 'required', 
        'email' => 'required', 
        'phone' => 'required']);
        $admin = new Admin
        (['fname' => $request->get('fname'),
        'lname' => $request->get('lname'),
        'username' => $request->get('user'),
        'password' => $request->get('pass'),
        'email' => $request->get('email'),
        'phone_number' => $request->get('phone')]);
        $admin->save();
        return redirect()->route('admin.create')->with('success','บันทึกข้อมูลเรียบร้อย');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
