<?php

namespace App\Http\Controllers\API\Professionals\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BusinessLocationSettingController extends Controller
{
    public function update(Request $request)
    {
        $user = User::where('id',Auth::id())->first();

        $validator = Validator::make($request->all(), [
            'country' => ['required','string'],
            'state' => ['nullable','string'],
            'city' => ['nullable','string'],
            'address' => ['nullable','string'],
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user->update([
                'country' => $request->input('country'),
                'state' => $request->input('state'),
                'city' => $request->input('city'),
                'address' => $request->input('address'),
            ]);

            return response()->json([
                'message' => 'Location updated successfully',
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
