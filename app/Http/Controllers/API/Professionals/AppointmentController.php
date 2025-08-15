<?php

namespace App\Http\Controllers\API\Professionals;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\AppointmentResource;
use App\Models\Availability;
use App\Models\DateOverride;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Fetch all services for the authenticated user
        try {
            $appointments = Appointment::with([
                'service:id,name',
                'customer:id,firstname,lastname,email,phone',
            ])->where('user_id', $user->id)->orderBy('id', 'DESC')->get();

            if ($appointments->isEmpty()) {
                return response()->json(['message' => 'No appointment found', 'status' => false], 200);
            }
            $appointments = AppointmentResource::collection($appointments);
            return response()->json([
                'status' => true,
                'data' => $appointments,
            ], 200);

        } catch (\Exception $e) {
           return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }

    }


    public function create(Request $request)
    {
        // Validate the request data

        $validator = Validator::make($request->all(), [
            'contact_id' => [
                'required',
                'integer',
                // This rule checks if the contact_id exists in the 'contacts' table
                Rule::exists('contacts', 'id'),
            ],
            'service_id' => [
                'required',
                'integer',
                Rule::exists('services', 'id'),
            ],
            'date' => ['required', 'string'],
            'time' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
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
            $appointment = new Appointment([
                'user_id'       => Auth::user()->id,
                'contact_id'    => $request->input('contact_id'),
                'service_id'    => $request->input('service_id'),
                'date'          => $request->input('date'),
                'time'          => $request->input('time'),
                'notes'         => $request->input('notes'),
            ]);
            $appointment->save();
            // You can customize the success response as needed
            return response()->json([
                'message' => 'Appointment created successfully',
                'status' => true,
                'data' => $appointment,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function show()
    {
        $user = Auth::user();
        // Fetch all weekly schedule rules
        $schedule = Availability::orderBy('id')->get(); // Order by ID to keep Sunday first

        // Fetch all date overrides and return just the date strings
        $overrideDates = DateOverride::pluck('override_date')->all();

        return response()->json([
            'status' => true,
            'schedule' => $schedule,
            'overrideDates' => $overrideDates,
        ], 200);
    }


    public function setAvailability(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [

            'schedule' => 'required|array|size:7',
            'schedule.*.name' => 'required|string',
            'schedule.*.isEnabled' => 'required|boolean',
            'schedule.*.startTime' => 'required|date_format:H:i',
            'schedule.*.endTime' => 'required|date_format:H:i',

            'overrideDates' => 'nullable|array',
            'overrideDates.*' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status'=>false,
                'errors' => $validator->errors()
            ], 422);
        }

        try{
            DB::transaction(function () use ($request, $user) {
            // 1. Update the weekly schedule

                foreach ($request->schedule as $dayData) {
                   $availability =  Availability::updateOrCreate(
                        // 1. Attributes to find the record by:
                        [
                            'user_id' => $user->id,
                            'day_of_week' => $dayData['name']
                        ],
                        // 2. Values to update or create with:
                        [
                            'is_enabled' => $dayData['isEnabled'],
                            'start_time' => $dayData['startTime'],
                            'end_time'   => $dayData['endTime'],
                        ]
                    );
                }

                // 2. Sync the date overrides
                // First, remove all existing overrides for the user
                DateOverride::where('user_id', $user->id)->delete();

                // Then, insert the new ones
                $newOverrides = [];
                foreach ($request->overrideDates as $date) {
                    $newOverrides[] = [
                        'override_date' => $date,
                        'user_id' => $user->id,
                    ];
                }
                if (!empty($newOverrides)) {
                    DateOverride::insert($newOverrides);
                }
            });
            return response()->json([
                'message' => 'Availability updated successfully',
                'status' => true,
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
