<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class ProviderAuthController extends Controller
{
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialite_user = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $ex) {
            return redirect()->route('login');
        }

        $user = User::where('email' , $socialite_user->email)->first();
        if(!$user){
            $user = User::create([
                'name' => $socialite_user->name,
                'provider_name' => $provider,
                'avatar' => $socialite_user->avatar,
                'email' => $socialite_user->email,
                'password' => Hash::make($socialite_user->id),
                'email_verified_at' => Carbon::now()
            ]);
        }

        auth()->login($user , $remember = true);
        alert()->success('ورود شما موفقیت آمیز بود.','تشکر')->persistent('حله');

        return redirect()->route('index');
    }
}
