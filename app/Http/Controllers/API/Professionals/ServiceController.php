<?php

namespace App\Http\Controllers\API\Professionals;

use App\Enum\ServiceStatus;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
     public function index()
    {
        // Fetch all services for the authenticated user
        try {
            $services = Service::where('user_id', Auth::id())->get();
            if ($services->isEmpty()) {
                return response()->json(['message' => 'No services found', 'status' => false], 200);
            }

            return response()->json([
                'status' => true,
                'services' => $services,
            ], 200);

        } catch (\Exception $e) {
           return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }

    }

    public function create(Request $request)
    {
        // Validate the request data

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['required', 'string', Rule::in(ServiceStatus::values())],
            'price' => ['numeric', 'min:0'],
            'serviceType' => ['required', 'string', 'max:255'],

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
            $service = new Service([
                'user_id' => Auth::user()->id, // Assuming the user is authenticated
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'status' => ServiceStatus::from($request->input('status')),
                'price' => $request->input('price'),
                'service_type' => $request->input('serviceType'),
            ]);
            $service->save();
            // You can customize the success response as needed
            return response()->json([
                'message' => 'Service created successfully',
                'status' => true,
                'service' => $service,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        // Fetch a specific service by ID
        $service = Service::find($id);

        if (!$service || $service->user_id !== Auth::id()) {
            return response()->json(['message' => 'Service not found', 'status' => false], 200);
        }

        return response()->json([
            'status' => true,
            'service' => $service,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['required', 'string', Rule::in(ServiceStatus::values())],
            'price' => ['numeric', 'min:0'],
            'serviceType' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status'=>false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Fetch the service
        $service = Service::find($id);

        if (!$service || $service->user_id !== Auth::id()) {
            return response()->json(['message' => 'Service not found', 'status' => false], 200);
        }

        // Update the service
        $service->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'status' => ServiceStatus::from($request->input('status')),
            'price' => $request->input('price'),
            'service_type' => $request->input('serviceType'),
        ]);

        return response()->json([
            'message' => 'Service updated successfully',
            'status' => true,
            'service' => $service,
        ], 200);
    }

    public function delete($id)
    {
        // Fetch the service
        $service = Service::find($id);

        if (!$service || $service->user_id !== Auth::id()) {
            return response()->json(['message' => 'Service not found', 'status' => false], 200);
        }

        // Delete the service
        $service->delete();

        return response()->json(['message' => 'Service deleted successfully', 'status' => true], 200);
    }

}
