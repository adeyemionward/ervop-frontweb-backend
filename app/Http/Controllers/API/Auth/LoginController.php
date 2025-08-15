<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use App\Enum\UserStatus;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $user = User::where('email', $request->input('email'))->first();

            if (!$user) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Email is not registered',
                    'status' => false
                ], 200);
            }

            // User status checks
            if ($user->status === UserStatus::Banned) {
                DB::rollBack();
                return response()->json(['message' => 'User is banned', 'status' => false], 403);
            }

            if ($user->status === UserStatus::Inactive) {
                DB::rollBack();
                return response()->json(['message' => 'User is inactive', 'status' => false], 403);
            }

            if ($user->status === UserStatus::Deactivate) {
                DB::rollBack();
                return response()->json(['message' => 'User is deactivated', 'status' => false], 403);
            }

            $credentials = $request->only('email', 'password');

            if (!$token = JWTAuth::attempt($credentials)) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Login credentials are invalid',
                    'status' => false
                ], 401);
            }

            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip()
            ]);
              // Authenticate the user
          // return $user = auth()->user();

            DB::commit();

            return response()->json([
                'message' => 'Login successful',
                'status' => true,
                'user' => $user,
                'token' => $token,
            ], 200);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'An error occurred during login',
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //resend otp
    public function resendOTP(Request $request){
        return $this->resendEmailOTP($request->email);
    }

    public function getJwtInfo(string $token){
        try {
            // Parse the token and get claims
            $payload = JWTAuth::setToken($token)->getPayload();

            return [
                'expiration' => $payload->get('exp'), // Expiration timestamp
                'is_valid' => true,
            ];
        } catch (TokenExpiredException $e) {
            // Token has expired
            return [
                'error' => 'Token has expired.',
                'is_valid' => false,
            ];
        } catch (TokenInvalidException $e) {
            // Token is invalid
            return [
                'error' => 'Token is invalid.',
                'is_valid' => false,
            ];
        } catch (\Exception $e) {
            // Any other errors
            return [
                'error' => 'An error occurred: ' . $e->getMessage(),
                'is_valid' => false,
            ];
        }
    }
}
