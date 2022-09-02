<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\VerificationCode;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class AuthOtpController extends Controller
{
    //return view of otp login page
    public function login() {
        return view('auth.otp.login');
    }

    // get OTP
    public function generate(Request $request) {

        #validate phone
        Validator::make($request->all(), [
            'phone' => 'required|exists:users,mobile_no',
        ])->validate();

        #generation otp
        try {
            $verificationCode = $this->generateOtp($request->phone);

        #return otp to screen
        $message = "Your OTP is ".$verificationCode->otp;

        Notification::route('smspoh', $request->phone)
        ->notify(new InvoicePaid($message));


        return redirect()->route('otp#verification',$verificationCode->user_id);
        } catch(\Throwable $th) {
            return $th;
        }

    }

    public function verification($user_id) {
        return view('auth.otp.otp_login')->with(['user_id' => $user_id]);
    }

    // --------final login with otp-------
    public function loginWithOtp(Request $request) {

        #validate
        Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'otp' => 'required',
        ]);

        #check user_id and otp
        $trueUserAndOtp = VerificationCode::where('user_id',$request->user_id)->where('otp',$request->otp)->first();

        $now = Carbon::now();

        if(!$trueUserAndOtp) {
            return redirect()->back()->with(['wrongOtp' => 'Your OTP is not correct. Please enter correct OTP.']);
        } elseif($trueUserAndOtp && $now->isAfter($trueUserAndOtp->expire_at)) {
            return redirect()->back()->with(['expireOtp' => 'Your OTP is expired. Please get new OTP.']);
        }

        #check registered user
        $user = User::whereId($request->user_id)->first();

        if($user) {

            #expire the otp
            $trueUserAndOtp->update([
                'expire_at' => Carbon::now(),
            ]);

            Auth::login($user);
            return redirect()->route('admin.home');
        }

        return redirect()->back()->with(['error' => 'Your OTP is not correct.']);
    }


    // ----------generate otp--------
    private function generateOtp($phone) {
        $user = User::where('mobile_no', $phone)->first();

       #check user is already in verification code table

        $verificationCode = VerificationCode::where('user_id', $user->id)->first();
        $now=Carbon::now(); //time that user get otp

        if($verificationCode && $now->isBefore($verificationCode->expire_at)) {
            return $verificationCode;
        }

        //if user is not already exist, create new otp
        return VerificationCode::create([
            'user_id' => $user->id,
            'otp' => rand(111111,999999),
            'expire_at' => Carbon::now()->addMinutes(1),
        ]);
    }


}
