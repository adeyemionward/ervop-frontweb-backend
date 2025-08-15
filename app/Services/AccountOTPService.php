<?php
    namespace App\Services;

use App\Enum\UserType;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Traits\Functions;
use Tymon\JWTAuth\Facades\JWTAuth;

    class AccountOTPService
    {
        use Functions;
        public function postOtpVerification(Request $request){
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'email'   => 'required|exists:users,email',
                'otp'       => 'required|string|max:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'status'=>false,
                    'errors' => $validator->errors()
                ], 422);
            }

            try{
                $otpEntry = User::where('email', $request->email)->where('verification_token', $request->otp)->first();

                if (!$otpEntry) {
                    return response()->json([
                        'message' => 'Invalid OTP',
                        'status' => false,
                        'otp' => $request->otp,
                    ], 400);
                }

                if ($otpEntry->otp == $request->otp) {
                    if($this->otpExpire($request->email)) {
                        return response()->json([
                            'message' => 'OTP Expired',
                            'status' => false,
                            'otp' => $request->otp,
                        ], 400);
                    }
                }

                $otpEntry->update(
                    [
                        'is_verified' => true,
                        'status' => UserType::Active,
                        'verification_token'=>null,
                        'verification_token_expires_at'=> null
                    ]
                );
                //generate JWT token
                // $token = auth()->login($otpEntry);
                $token = JWTAuth::fromUser($otpEntry);
                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return response()->json([
                    'message' => 'Error Verifying OTP. Please try later',
                    'status' => false,
                    'error' => $th->getMessage()
                ], 500);
            }
            return response()->json([
                'message' => 'OTP Verified Successfully',
                'status' => true,
                'user' => $otpEntry,
                'token' => $token,
            ], 200);
        }
        }
?>
