<?php

namespace App\Http\Controllers\API\Professionals\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BusinessProfileSettingController extends Controller
{
     public function update(Request $request)
    {
        $user = User::where('id',Auth::id())->first();

        $validator = Validator::make($request->all(), [
            'businessName' => ['unique:users,business_name,' . $user->id, 'required', 'string', 'max:50'],
            'businessIndustry' => ['required', 'string', 'max:255'],
            'ervopUrl' => ['unique:users,ervop_url,' . $user->id, 'required', 'string', 'max:50'],
            'businessDescription' => ['required', 'string', 'max:255'],
            'currency' => ['required', 'string', 'max:255'],
           
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status'=>false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            
            // 3. Update document fields
            $user->update([
                'business_name' => $request->input('businessName'),
                'business_industry' => $request->input('businessIndustry'),
                'ervop_url' => $request->input('ervopUrl'),
                'business_description' => $request->input('businessDescription'),
                'currency' => $request->input('currency'),
            ]);

            return response()->json([
                'message' => 'Business updated successfully',
                'status' => true,
                'data' => $user
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred',
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
