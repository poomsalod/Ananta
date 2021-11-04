<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Account;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Food;
use App\Models\User_profile;
use App\Models\Admin_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'username' => ['required', 'string', 'max:255'],
    //         'first_name' => ['required', 'string', 'max:255'],
    //         'last_name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);
    // }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    // protected function create(array $data)
    // {
    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'role' => '2',
    //         'password' => Hash::make($data['password']),
    //     ]);
    // }

    function register(Request $request)
    {
        $request->validate([
            'username' => 'required|min:6|max:30|unique:account',
            'password' => 'required|min:6|max:30|confirmed',
            'f_name' => 'required|max:40',
            'l_name' => 'required|max:40',
            'email' => 'required|max:40',
            'bday' => 'required',
        ], [
            'username.required' => 'กรุณากรอกชื่อผู้ใช้',
            'username.unique' => 'มีชื่อผู้ใช้นี้อยู่แล้ว โปรดเปลี่ยนชื่อผู้ใช้ใหม่',
            'username.min' => 'ต้องมีตัวอักษรอย่างน้อย 6 ตัว',
            'username.max' => 'มีตัวอักษรเกิน 30 ตัว',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องมีอย่างน้อย 6 ตัว',
            'password.max' => 'มีรหัสผ่านเกิน 30 ตัว',
            'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
            'f_name.required' => 'กรุณากรอกชื่อ',
            'l_name.required' => 'กรุณากรอกนามสกุล',
            'email.required' => 'กรุณากรอกอีเมล',
            'bday.required' => 'กรุณากรอกวันเกิด',
        ]);



        $account = new Account();
        $account->username = $request->username;
        $account->password = \Hash::make($request->password);

        if ($account->save()) {
            $new_name = time() . '.jpg';
            Storage::copy('/public/images/avatar.jpg', '/public/images/user/'.$new_name);
            
            $account_id = $account->account_id;
            $user_profile = new User_profile([
                'account_id' => $account_id,
                'f_name' => $request->f_name,
                'l_name' => $request->l_name,
                'email' => $request->email,
                'image' => $new_name,
                'birthday' => $request->bday,
            ]);
            if ($user_profile->save()) {
                return redirect()->back()->with('success', 'สมัครสมาชิกเรียบร้อย');
            } else {
                return redirect()->back()->with('error', 'ไม่สามารถสมัครสมาชิกได้ โปรดติดต่อผู้ดูแลระบบ');
            }
        } else {
            return redirect()->back()->with('error', 'ไม่สามารถสมัครสมาชิกได้ โปรดติดต่อผู้ดูแลระบบ');
        }
    }

    public function index()
    {
        $food = Food::latest()->take(3)->get();
        return view('auth.register', compact('food'));
    }

    public function admin_from()
    {
        $food = Food::latest()->take(3)->get();
        return view('auth.register_admin', compact('food'));
    }

    function admin_register(Request $request)
    {
        $request->validate([
            'username' => 'required|min:6|max:30|unique:account',
            'password' => 'required|min:6|max:30|confirmed',
            'f_name' => 'required|max:40',
            'l_name' => 'required|max:40',
            'email' => 'required|max:40',
        ], [
            'username.required' => 'กรุณากรอกชื่อผู้ใช้',
            'username.unique' => 'มีชื่อผู้ใช้นี้อยู่แล้ว โปรดเปลี่ยนชื่อผู้ใช้ใหม่',
            'username.min' => 'ต้องมีตัวอักษรอย่างน้อย 6 ตัว',
            'username.max' => 'มีตัวอักษรเกิน 30 ตัว',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องมีอย่างน้อย 6 ตัว',
            'password.max' => 'มีรหัสผ่านเกิน 30 ตัว',
            'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
            'f_name.required' => 'กรุณากรอกชื่อ',
            'l_name.required' => 'กรุณากรอกนามสกุล',
            'email.required' => 'กรุณากรอกอีเมล',
        ]);



        $account = new Account();
        $account->username = $request->username;
        $account->password = \Hash::make($request->password);
        $account->role = 1;

        if ($account->save()) {
            $new_name = time() . '.jpg';
            Storage::copy('/public/images/avatar.jpg', '/public/images/admin/'.$new_name);
            
            $account_id = $account->account_id;
            $admin_profile = new Admin_profile([
                'account_id' => $account_id,
                'f_name' => $request->f_name,
                'l_name' => $request->l_name,
                'email' => $request->email,
                'image' => $new_name,
            ]);
            if ($admin_profile->save()) {
                return redirect()->back()->with('success', 'สมัครสมาชิกเรียบร้อย');
            } else {
                return redirect()->back()->with('error', 'ไม่สามารถสมัครสมาชิกได้ โปรดติดต่อผู้ดูแลระบบ');
            }
        } else {
            return redirect()->back()->with('error', 'ไม่สามารถสมัครสมาชิกได้ โปรดติดต่อผู้ดูแลระบบ');
        }
    }
}
