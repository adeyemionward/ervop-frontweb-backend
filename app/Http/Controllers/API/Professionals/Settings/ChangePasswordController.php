<?php

namespace App\Http\Controllers\API\Professionals\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    public function update(Request $request)
    {
        $user = $request->user();

        // Validate input
        $validator = Validator::make($request->all(), [
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status'=>false,
                'errors' => $validator->errors()
            ], 422);
        }


        // Check current password
        if (!Hash::check($request->currentPassword, $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect.',
                'status'=>false,
            ], 400);
        }

        // Update password
        $user->password = Hash::make($request->newPassword);
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully.',
            'status' => true
        ], 200);
    }
}
