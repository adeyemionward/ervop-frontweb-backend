<?php

namespace App\Http\Controllers\ClientPortal\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccessController extends Controller
{
    public function verify(Request $request)
    {
        $valid = "123456"; // your real code

        if ($request->access_code !== $valid) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid access code.'
            ], 401);
        }

        session(['portal_portal_access' => true]);

        return response()->json([
            'status' => true,
            'message' => 'Access granted.'
        ], 200);
    }
}
