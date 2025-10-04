<?php

namespace App\Http\Controllers\API\Professionals\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotificationSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class NotificationSettingController extends Controller
{
    // Update or create toggle immediately
    public function update(Request $request)
    {
        $request->validate([
            'type' => 'required|string',   // e.g. "newAppointment"
            'enabled' => 'required|boolean'
        ]);

        $setting = NotificationSetting::updateOrCreate(
            ['user_id' => Auth::id(), 'type' => $request->type],
            ['enabled' => $request->enabled]
        );

        return response()->json([
            'success' => true,
            'data' => $setting
        ]);
    }

    // Fetch all toggles for a user
    public function index()
    {
        $settings = NotificationSetting::where('user_id', Auth::id())->get();

        return response()->json($settings);
    }
}
