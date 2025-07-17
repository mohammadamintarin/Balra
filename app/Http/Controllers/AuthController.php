<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\OTP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function auth(Request $request)
    {
        if($request->method() == 'GET'){
            return view('auth.index');
        }
        $request->validate([
            'mobile' => 'required|iran_mobile'
        ]);

        try {
            $user = User::where('mobile' , $request->mobile)->first();
            $otpCode = mt_rand(1000 , 9999);
            $loginToken = Hash::make('fasdj!fhalksdjf@eriowiroweiu&&');
            if ($user)
            {
                $user->update([
                    'otp' => $otpCode,
                    'token' => $loginToken,
                ]);
            }else{
                $user= User::create([
                    'mobile' => $request->mobile,
                    'otp' => $otpCode,
                    'token' => $loginToken,
                ]);
            }
            $user->notify(new OTP($otpCode));

            return response([
                'token' => $loginToken
            ] , 200);

        }catch(\Exception $ex){
            return response([
                'erorr' => $ex->getMessage()
            ] , 422);
        }
    }

    public function otp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:4',
            'token' => 'required'
        ]);
        $user = User::where('token' , $request->token)->firstOrFail();

        if($user->otp == $request->otp){
            auth()->login($user , $remember = true);
            return response(["ok"] , 200);
        }else{
            return response(['otp' => 'کد نادرست است'] , 422);
        }
    }

    public function resend(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);
        try {
            $user = User::where('token' , $request->token)->firstOrFail();
            $otpCode = mt_rand(10000 , 99999);
            $token = Hash::make('fasdjfhalksdjf@eriowiroweiu&&');

            $user->update([
                'otp' => $otpCode,
                'token' => $token,
            ]);

            $user->notify(new OTP($otpCode));

            return response([
                'token' => $token
            ] , 200);

        }catch(\Exception $ex){
            return response([
                'erorr' => $ex->getMessage()
            ] , 422);
        }
    }
    public function perform()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('home.index');
    }
}
