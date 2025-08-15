<?php

namespace App\Http\Controllers\API\Auth;

use App\Enum\BusinessType;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AccountOTPService;
use App\Traits\Functions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    use Functions;
    public function register(Request $request)
    {
        // Validate the request data

        $validator = Validator::make($request->all(), [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'businessType' => ['required', 'string', Rule::in(BusinessType::values())],
            'businessName' => ['required', 'string', 'max:255', 'unique:users,business_name'],
            'industry' => ['required', 'string', 'max:255'],
            'ervopUrl' => ['required', 'string', 'unique:users,ervop_url'],
            'email' => ['required_if:business_type,professional,hybrid', 'nullable', 'email', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:15', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status'=>false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Create the user
        $user = new User([
            'firstname' => $request->input('firstName'),
            'lastname' => $request->input('lastName'),
            'business_type' => $request->input('businessType'),
            'business_name' => $request->input('businessName'),
            'business_industry' => $request->input('industry'),
            'ervop_url' => $request->input('ervopUrl'),
            'website' => $request->input('website'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
        ]);
        $user->save();

        //send otp to email and update the user data
        $this->sendEmailOTP($request->email);
        // You can customize the success response as needed
        return response()->json([
            'message' => 'User created successfully',
            'status' => true,
            'user' => $user,
        ], 201);
    }

    public function secondStepValidation()
    {
        $errors = [];

        if ($this->isEmailExist()) {
            $errors['email'] = 'This email is already in use.';
        }

        if ($this->isPhoneExist()) {
            $errors['phone'] = 'This phone is already in use.';
        }

        if (!empty($errors)) {
            return response()->json([
                'status' => false,
                'errors' => $errors
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Validation passed.'
        ]);
    }


    public function otpVerification(Request $request, AccountOTPService $accountOTPService){

        return $accountOTPService->postOtpVerification($request);
    }
}
