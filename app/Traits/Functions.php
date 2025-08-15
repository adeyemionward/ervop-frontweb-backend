<?php
namespace App\Traits;

use App\Mail\EmailOTPMail;;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

trait Functions
{
    function generateRandomNumbers()
    {
        $characters = '0123456789';
        $randomString = '';
        for ($i = 0; $i < 4; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }



    function otpExpire($email){
        $user = User::where('email',$email)->first();
        $otpTimestamp = $user->otp_timestamp;
        $expiresAt = Carbon::parse($otpTimestamp)->addMinutes(10);
        if (Carbon::now()->greaterThan($expiresAt)) {
            // OTP is expired
            return true;
        }
    }

    function sendEmailOTP($email){
        $user = User::where('email', $email)->first();
        //generate OTP
        $otpTimestamp =  Carbon::now();
        $otp =  $this->generateRandomNumbers();

        // Send OTP via email
        //$mail = Mail::to($email)->send(new EmailOTPMail($otp));
        ////if($mail){
            $user->update(['verification_token' => $otp, 'verification_token_expires_at'=> $otpTimestamp]);
       // }
        return true;
    }

    function resendEmailOTP($email){
        $user = User::where('email', $email)->first();
        //generate OTP
        $otpTimestamp =  Carbon::now();
        $otp =  $this->generateRandomNumbers();

        // Send OTP via email
        $mail = Mail::to($email)->send(new EmailOTPMail($otp));
        //$messageOtp  =  $this->sendSMS($request->input('phone'), $otp);
        if($mail){
            $user->update(['verification_token' => $otp, 'verification_token_expires_at'=> $otpTimestamp]);
        }
        return $this->jsonResponse(true, 200, "OTP Resent.", ['User Email' => $email], false, false);
    }

    function isEmailExist(){
        $email = request()->input('email');
        $user = User::where('email', $email)->first();
        if ($user) {
            return response()->json([
                'message' => 'Email already exists',
                'status' => false,
            ], 422);
        }

    }

    function isPhoneExist(){
        $phone = request()->input('phone');
        $user = User::where('phone', $phone)->first();
        if ($user) {
            return response()->json([
                'message' => 'Phone already exists',
                'status' => false,
            ], 422);
        }

    }

    //     private function isEmailExist($email)
    // {
    //     return User::where('email', $email)->exists();
    // }

    // private function isPhoneExist($phone)
    // {
    //     return User::where('phone', $phone)->exists();
    // }

    function isBusinessNameExist(){
        $businessName = request()->input('businessName');
        $user = User::where('business_name', $businessName)->first();
        if ($user) {
            return response()->json([
                'message' => 'Business name already exists',
                'status' => false,
            ], 422);
        }
    }

    function isErvopUrlExist(){
        $ervopUrl = request()->input('ervopUrl');
        $user = User::where('ervop_url', $ervopUrl)->first();
        if ($user) {
            return response()->json([
                'message' => 'Ervop URL already exists',
                'status' => false,
            ], 422);
        }
    }

    function isWebsiteExist(){
        $website = request()->input('website');
        $user = User::where('website', $website)->first();
        if ($user) {
            return response()->json([
                'message' => 'Website already exists',
                'status' => false,
            ], 422);
        }
    }

}
