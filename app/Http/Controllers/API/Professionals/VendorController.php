<?php

namespace App\Http\Controllers\API\Professionals;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{
    public function index()
    {
        // Fetch all services for the authenticated user
        try {
            $Vendor = Vendor::where('user_id', Auth::id())->get();
            if ($Vendor->isEmpty()) {
                return response()->json(['message' => 'No Vendor found', 'status' => false], 200);
            }

            return response()->json([
                'status' => true,
                'data' => $Vendor,
            ], 200);

        } catch (\Exception $e) {
           return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }

    }

    public function create(Request $request)
    {
        // Validate the request data

        $validator = Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:Vendors'],
            'company' => ['nullable', 'string', 'max:255'],
            // 'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'tags' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status'=>false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Check if the user is authenticated
            // Create the user
            $Vendor = new Vendor([
                'user_id'   => Auth::user()->id,
                'firstname' => $request->input('firstname'),
                'lastname'  => $request->input('lastname'),
                'email'     => $request->input('email'),
                'phone'     => $request->input('phone'),
                'company'   => $request->input('company'),
                'status'    => 'active',
                'tags'      => $request->input('tags'),
            ]);
            $Vendor->save();
            // You can customize the success response as needed
            return response()->json([
                'message' => 'Vendor created successfully',
                'status' => true,
                'data' => $Vendor,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {

        try {
            $Vendor = Vendor::where('user_id', Auth::id())->where('id', $id)->first();
            if (is_null($Vendor)) {
                return response()->json(['message' => 'No Vendor found', 'status' => false], 200);
            }

            return response()->json([
                'status' => true,
                'client' => $Vendor,
            ], 200);

        } catch (\Exception $e) {
           return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }

    }

    public function update(Request $request, $id)
    {

        // Find the Vendor
        $Vendor = Vendor::find($id);

        if (!$Vendor) {
            return response()->json([
                'message' => 'Vendor not found',
                'status' => false,
            ], 404);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'email'     => ['nullable', 'string', 'email', 'max:255'],
            'phone'     => ['required', 'string', 'max:255', Rule::unique('Vendors')->ignore($Vendor->id)],
            'company'   => ['nullable', 'string', 'max:255'],
            'tags'      => ['nullable', 'string'],
            // 'status'    => ['nullable', 'in:active,inactive'], // optional if you allow status update
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Update Vendor fields
            $Vendor->update([
                'firstname' => $request->input('firstname'),
                'lastname'  => $request->input('lastname'),
                'email'     => $request->input('email'),
                'phone'     => $request->input('phone'),
                'company'   => $request->input('company'),
                'tags'      => $request->input('tags'),
                // 'status'    => $request->input('status', $Vendor->status), // keep old if not provided
            ]);

            return response()->json([
                'message' => 'Vendor updated successfully',
                'status' => true,
                'data' => $Vendor,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred',
                'status' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        // Find the Vendor
        $Vendor = Vendor::find($id);

        if (!$Vendor) {
            return response()->json([
                'message' => 'Vendor not found',
                'status' => false,
            ], 404);
        }

        try {
            $Vendor->delete();

            return response()->json([
                'message' => 'Vendor deleted successfully',
                'status' => true,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred',
                'status' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
