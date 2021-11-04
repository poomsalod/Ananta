<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User_profile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class Api_auth extends Controller
{
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
            Storage::copy('/public/images/avatar.jpg', '/public/images/user/' . $new_name);

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
                $token = $account->createToken('postman')->plainTextToken;
                $response = [
                    'user' => $account,
                    'token' => $token 
                ];
                return response($response,201);
            } else {
                $response = [
                    'error' => 'ไม่สามารถสมัครสมาชิกได้ โปรดติดต่อผู้ดูแลระบบ',
                ];
                return response($response,401);
            }
        } else {
            $response = [
                'error' => 'ไม่สามารถสมัครสมาชิกได้ โปรดติดต่อผู้ดูแลระบบ',
            ];
            return response($response,401);
        }
    }

    function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

    function login(Request $request)
    {
        $credentials = request()->only(['username', 'password']);
        if (!auth()->validate($credentials)) {
            return response([
                'message' => 'ชื่อผู้ใช้หรือรหัสผ่าน ไม่ถูกต้อง'
            ],401);
        } else {
            $user = Account::where('username', $credentials['username'])->first();
            $user->tokens()->delete();
            $token = $user->createToken($request->get('device_name'))->plainTextToken;
            $response = $token ;
            
            // $response = [
            //     'user' => $user,
            //     'token' => $token 
            // ];
            return response($response,201);
        }
    }
}
