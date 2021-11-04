<?php

namespace App\Http\Middleware;

use App\Models\Account;
use App\Models\Food_rating;
use App\Models\User_nutrition;
use App\Models\User_profile;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

class isUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == 0) {
            $have_rating = Food_rating::where('user_id', Auth::user()->user_profile->user_id)->count();
            $have_nutrition = User_nutrition::where('user_id', Auth::user()->user_profile->user_id)->count();
            if ($have_nutrition > 0) {
                $user = Auth::user();
                $user->last_used_at = Carbon::now();
                $user->save();

                
                return $next($request);
                
            } else {
                if (Route::current()->getName() == 'add_nutrition' || Route::current()->getName() == 'add_profile') {
                    // dd('nuti');
                } else {

                    return redirect()->route('add_nutrition');
                }
                // return $next($request);
                // return redirect()->route('add_nutrition');
            }
            // dd($next($request));
            return $next($request);
            // return redirect()->route('add_nutrition');
        } else {
            return redirect()->route('login');
        }
    }
}
