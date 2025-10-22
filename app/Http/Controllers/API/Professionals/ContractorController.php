<?php

namespace App\Http\Controllers\API\Professionals;

use App\Http\Controllers\Controller;
use App\Models\Contractor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class ContractorController extends Controller
{
    public function index()
    {
        // Fetch all services for the authenticated user
        try {
            $Contractor = Contractor::where('user_id', Auth::id())->get();
            if ($Contractor->isEmpty()) {
                return response()->json(['message' => 'No Contractor found', 'status' => false], 200);
            }

            return response()->json([
                'status' => true,
                'data' => $Contractor,
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
            'address' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'account_number' => ['nullable', 'string', 'max:255'],
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
            $Contractor = new Contractor([
                'user_id'   => Auth::user()->id,
                'firstname' => $request->input('firstname'),
                'lastname'  => $request->input('lastname'),
                'email'     => $request->input('email'),
                'phone'     => $request->input('phone'),
                'company'   => $request->input('company'),
                'address'   => $request->input('address'),
                'bank_name'   => $request->input('bank_name'),
                'account_number'   => $request->input('account_number'),
                'status'    => 'active',
            ]);
            $Contractor->save();
            // You can customize the success response as needed
            return response()->json([
                'message' => 'Contractor created successfully',
                'status' => true,
                'data' => $Contractor,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {

        try {
            $Contractor = Contractor::where('user_id', Auth::id())->where('id', $id)->first();
            if (is_null($Contractor)) {
                return response()->json(['message' => 'No Contractor found', 'status' => false], 200);
            }

            return response()->json([
                'status' => true,
                'client' => $Contractor,
            ], 200);

        } catch (\Exception $e) {
           return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }

    }

    public function update(Request $request, $id)
    {

        // Find the Contractor
        $Contractor = Contractor::find($id);

        if (!$Contractor) {
            return response()->json([
                'message' => 'Contractor not found',
                'status' => false,
            ], 404);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'email'     => ['nullable', 'string', 'email', 'max:255'],
            'phone'     => ['required', 'string', 'max:255', Rule::unique('Contractors')->ignore($Contractor->id)],
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
            // Update Contractor fields
            $Contractor->update([
                'firstname' => $request->input('firstname'),
                'lastname'  => $request->input('lastname'),
                'email'     => $request->input('email'),
                'phone'     => $request->input('phone'),
                'company'   => $request->input('company'),
                'tags'      => $request->input('tags'),
                // 'status'    => $request->input('status', $Contractor->status), // keep old if not provided
            ]);

            return response()->json([
                'message' => 'Contractor updated successfully',
                'status' => true,
                'data' => $Contractor,
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
        // Find the Contractor
        $Contractor = Contractor::find($id);

        if (!$Contractor) {
            return response()->json([
                'message' => 'Contractor not found',
                'status' => false,
            ], 404);
        }

        try {
            $Contractor->delete();

            return response()->json([
                'message' => 'Contractor deleted successfully',
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
