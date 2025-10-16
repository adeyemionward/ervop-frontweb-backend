<?php

namespace App\Http\Controllers\API\Professionals\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class AccountSettingController extends Controller
{
    public function destroy(Request $request)
    {
        $user = $request->user();

        // Optional: Require password for extra security
        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Password is incorrect.',
                'status' => false
            ], 400);
        }
         // Anonymize personal info
        $user->update([
            'firstname' => 'Deleted User',
            'lastname' => 'Deleted User',
            'email' => null,
            'phone' => null,
            'ervop_url' => null,
            'website' => null,
            'business_name' => null,
            'business_description' => null,
        ]);

        // Soft delete the user
        $user->delete();

        return response()->json([
            'message' => 'Your account has been permanently deleted.',
            'status' => true
        ], 200);
    }
}
