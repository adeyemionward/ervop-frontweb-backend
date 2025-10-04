<?php

namespace App\Http\Controllers\API\Professionals\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class ProfileSettingController extends Controller
{
    public function update(Request $request)
    {
        $user = User::where('id',Auth::id())->first();

        $validator = Validator::make($request->all(), [
            'firstname' => ['required','string'],
            'lastname' => ['required','string'],
            'email' => ['unique:users,email,' . $user->id, 'required', 'email', 'max:50'],
            'phone' => ['unique:users,phone,' . $user->id, 'required'],
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            
            // 3. Update document fields
            $user->update([
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
            ]);

            return response()->json([
                'message' => 'User updated successfully',
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
