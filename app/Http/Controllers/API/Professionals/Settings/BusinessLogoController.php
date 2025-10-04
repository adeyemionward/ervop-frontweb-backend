<?php

namespace App\Http\Controllers\API\Professionals\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class BusinessLogoController extends Controller
{
    public function update(Request $request)
    {
         $user = User::where('id',Auth::id())->first();

        $validator = Validator::make($request->all(), [
            'business_logo' => ['required','file','mimes:jpeg,png,jpg,gif,svg','max:2048'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // 2. Upload new files
            if ($request->hasFile('business_logo')) {
                $file = $request->file('business_logo');
                    $fileName = time() . '_' . str_replace(' ', '', $file->getClientOriginalName());
                    $file->move(public_path('business_logo/'), $fileName);

                    $user->update([
                        'business_logo' => config('app.url') . '/business_logo/' . $fileName,
                    ]);
            }

           
            return response()->json([
                'message' => 'Logo updated successfully',
                'status' => true,
                'data' => $fileName
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
