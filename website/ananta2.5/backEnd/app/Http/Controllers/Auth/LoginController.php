<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Food;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected function redirectTo()
    {
        if (Auth()->user()->role == 1) {
            return route('admin.food');
        } elseif (Auth()->user() == 2) {
            return route('user.dashboard');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            // 'username'=>'required|username',
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'กรุณากรอกชื่อผู้ใช้',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
        ]);

        if (auth()->attempt(array('username' => $input['username'], 'password' => $input['password']))) {

            if (auth()->user()->role == 1) {
                return redirect()->route('admin_index');
            } elseif (auth()->user()->role == 0) {
                return redirect()->route('user_home');
            } elseif (auth()->user()->role == 2) {
                return redirect()->route('login')->with('error', 'บัญชีนี้ถูกระงับ โปรดติดต่อผู้ดูแลระบบ');
            }
        } else {
            return redirect()->route('login')->with('error', 'ชื่อผู้ใช้หรือรหัสผ่าน ไม่ถูกต้อง');
        }
    }

    public function index()
    {
        $food = Food::latest()->take(3)->get();
        return view('auth.login', compact('food'));
    }
}
