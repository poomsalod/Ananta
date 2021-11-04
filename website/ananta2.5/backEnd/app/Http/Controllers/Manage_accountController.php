<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Manage_accountController extends Controller
{
    public function index()
    {
        $baduser = Account::where('role', 2)->latest();
        $count = $baduser->count();
        $baduser = $baduser->paginate(10);

        return view('Admin.account_index', compact('baduser', 'count'))->with('i', 0);
    }

    public function show()
    {
        $user = Account::where('role', 0)->latest()->get();
        $baduser = [];
        foreach ($user as $key => $value) {
            if ($value->last_used_at != null) {
                // dd(strtotime($value->last_used_at));
                
                // dd(idate('y', strtotime($value->last_used_at)));
                // $d = Carbon::createFromDate('2021', Carbon::now()->format('d'));
                //  dd(idate('Y', strtotime($value->last_used_at)) - Carbon::now()->format('Y'));
                // dd($value->created_at->diff(Carbon::now())->y);
                if (Carbon::now()->format('Y') - idate('Y', strtotime($value->last_used_at))  > 2) {
                    $baduser[] = $value;
                }
            }
        }
        $count = count($baduser);

        return view('Admin.account_add', compact('baduser','count'))->with('i', 0);
    }

    public function add(Request $request)
    {
        $user = Account::find($request->get('account_id'));
        $user->role = 2;
        $user->save();

        return redirect()->back()->with('success', 'ระงับบัญชี '.$request->get('account_id').' เรียบร้อย');
    }

    public function edit(Request $request)
    {
        $user = Account::find($request->get('account_id'));
        $user->role = 0;
        $user->save();

        return redirect()->back()->with('success', 'ยกเลิกการระงับบัญชี '.$request->get('account_id').' เรียบร้อย');
    }
}
