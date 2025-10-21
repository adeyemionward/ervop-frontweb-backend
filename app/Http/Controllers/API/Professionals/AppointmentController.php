<?php

namespace App\Http\Controllers\API\Professionals;

use App\Enum\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\AppointmentResource;
use App\Models\Availability;
use App\Models\DateOverride;
use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Traits\HandleUploadDocuments;
class AppointmentController extends Controller
{
    use HandleUploadDocuments;
    public function index()
    {
        $user = Auth::user();
        // Fetch all services for the authenticated user
        try {
            $appointments = Appointment::with([
                'service:id,name',
                'project:id,name',
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

    public function getAvailableSlots(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'date' => 'required|date_format:Y-m-d',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'status'=>false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $date = Carbon::parse($request->input('date'));
            $dayOfWeek = $date->format('l'); // e.g., 'Monday'

            // 1. Check for date overrides (holidays, vacation, etc.)
            $isOverridden = DateOverride::where('user_id',Auth::user()->id)->where('override_date', $date->format('Y-m-d'))->first();
            if ($isOverridden) {
                return response()->json(['available_slots' => []]); // Day is completely unavailable
            }

            // 2. Find the professional's schedule for that day of the week
            $availability = Availability::where('user_id',Auth::user()->id)->where('day_of_week', $dayOfWeek)->first();
            if (!$availability || !$availability->is_enabled) {
                return response()->json(['available_slots' => []]); // Not a working day
            }

            // 3. Get all existing appointments for that day to find booked slots
            $bookedSlots = Appointment::where('user_id',Auth::user()->id)
                ->whereDate('date', $date->format('Y-m-d'))
                ->get()
                ->map(function ($appointment) {
                    return Carbon::parse($appointment->time)->format('H:i');
                });

            // 4. Generate potential time slots for the day (e.g., in 60-minute intervals)
            $availableSlots = [];
            $slot = Carbon::parse($date->format('Y-m-d') . ' ' . $availability->start_time);
            $endTime = Carbon::parse($date->format('Y-m-d') . ' ' . $availability->end_time);

            while ($slot < $endTime) {
                $time = $slot->format('H:i');
                // Add the slot only if it hasn't been booked
                if (!$bookedSlots->contains($time)) {
                    $availableSlots[] = $time;
                }
                $slot->addHour(); // Assuming 1-hour appointment slots
            }

            // You can customize the success response as needed
                return response()->json([
                    'status' => true,
                    'available_slots' => $availableSlots,
                ], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
            }

    }

    public function create(Request $request)
    {
        // Validate the request data

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:50'],
            'contact_id' => [
                'required',
                'integer',
                // This rule checks if the contact_id exists in the 'contacts' table
                Rule::exists('contacts', 'id'),
            ],
            'project_id' => [
                'nullable',
                'integer',
                Rule::exists('projects', 'id'),
            ],

            'service_id' => [
                'nullable',
                'integer',
                Rule::exists('services', 'id'),
            ],
            'date' => ['required', 'string'],
            'time' => ['required', 'string'],
            'amount' => ['nullable', 'numeric'],
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
                'title'         => $request->input('title'),
                'user_id'       => Auth::user()->id,
                'contact_id'    => $request->input('contact_id'),
                'project_id'    => $request->input('project_id'),
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


    public function show(Appointment $appointment)
    {
        try {
            // 1. Authorization
            if ($appointment->user_id !== Auth::id()) {
                return response()->json([
                    'message' => 'Unauthorized',
                    'status'  => false,
                ], 403);
            }

            // 2. Eager-load relationships
            $appointment->load([
                'service:id,name',
                'customer:id,firstname,lastname,email,phone',
                // 'notesHistory:id,appointment_id,content,created_at',
                'notesHistory.user:id,firstname,lastname',
                'invoices.items',
                'invoices.payments',
                'documents.files',
            ]);

            // 3. Format response
            $data = [
                'id'                => $appointment->id,
                'user_id'           => $appointment->user_id,
                'contact_id'        => $appointment->contact_id,
                'service_id'        => $appointment->service_id,
                'date'              => $appointment->date,
                'time'              => $appointment->time,
                'amount'            => $appointment->amount,
                'appointment_status'=> $appointment->appointment_status,
                'notesHistory' => $appointment->notesHistory ? $appointment->notesHistory->map(function ($note) {
            return [
                'id'             => $note->id,
                'appointment_id' => $note->appointment_id,
                'content'        => $note->content,
                'author'         => $note->user->firstname . ' ' . $note->user->lastname ?? 'Unknown', // ✅ include user firstname
                'created_at'     => $note->created_at,
            ];
        }) : [],

                'created_at'        => $appointment->created_at,
                'updated_at'        => $appointment->updated_at,
                'service'           => $appointment->service,
                'customer'          => $appointment->customer,
                'invoices'          => $appointment->invoices ? $appointment->invoices->map(function ($invoice) {
                    return [
                        'id'                  => $invoice->id,
                        'user_id'             => $invoice->user_id,
                        'contact_id'          => $invoice->contact_id,
                        'project_id'          => $invoice->project_id,
                        'appointment_id'      => $invoice->appointment_id,
                        'invoice_no'          => $invoice->invoice_no,
                        'invoice_type'        => $invoice->invoice_type,
                        'issue_date'          => $invoice->issue_date,
                        'due_date'            => $invoice->due_date,
                        'subtotal'            => $invoice->subtotal,
                        'tax_percentage'      => $invoice->tax_percentage,
                        'discount_percentage' => $invoice->discount_percentage,
                        'tax_amount'          => $invoice->tax_amount,
                        'discount'            => $invoice->discount,
                        'total'               => $invoice->total,
                        'remaining_balance'   => $invoice->remaining_balance,
                        'notes'               => $invoice->notes,
                        'created_at'          => $invoice->created_at,
                        'updated_at'          => $invoice->updated_at,
                        'items'               => $invoice->items,
                        'payments'            => $invoice->payments,
                    ];
                })
                :[],
                'documents' => $appointment->documents ? $appointment->documents->map(function ($doc) {
                    return [
                        'id'           => $doc->id,
                        'user_id'      => $doc->user_id,
                        'contact_id'   => $doc->contact_id,
                        'project_id'   => $doc->project_id,
                        'appointment_id'=> $doc->appointment_id,
                        'title'        => $doc->title,
                        'tags'         => $doc->tags,
                        'created_at'   => $doc->created_at,
                        'updated_at'   => $doc->updated_at,
                        'files'        => $doc->files,
                    ];
                })
                :[],
            ];

            return response()->json([
                'status' => true,
                'data'   => $data,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred',
                'status'  => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        // Find the contact
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json([
                'message' => 'Appointment not found',
                'status' => false,
            ], 200);
        }

        try {
            $appointment->delete();

            return response()->json([
                'message' => 'Appointment deleted successfully',
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

    public function createAppointmentDocs(Request $request){

        $validator = Validator::make($request->all(), [
            'contact_id' => ['nullable'],
            'project_id' => ['nullable'],
            'title' => ['required', 'string'],
            // 'business_docs' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg,pdf', 'max:2048'],
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
            $document = Document::create([
                'user_id'       => Auth::id(),
                'contact_id'    => $request->input('contact_id') ?? NULL,
                'project_id'    => $request->input('project_id') ?? NULL,
                'appointment_id'=> $request->input('appointment_id') ?? NULL,
                'title'         => $request->input('title'),
                'tags'          => $request->input('tags'),
            ]);

            if ($request->hasFile('business_docs')) {
                foreach ($request->file('business_docs') as $file) {
                    $fileName = time() . '_' . str_replace(' ', '', $file->getClientOriginalName());
                    $file->move(public_path('business_docs/'), $fileName);

                    $document->files()->create([
                        'user_id'       => Auth::id(),
                        'contact_id'    => $request->input('contact_id') ?? NULL,
                        'file_path'     => config('app.url') . '/business_docs/' . $fileName,
                        'file_type'     => $file->getClientMimeType(),
                    ]);
                }
            }

            // You can customize the success response as needed
            return response()->json([
                'message' => 'Document created successfully',
                'status' => true,
                'data' => $document->load('files'),
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }
    }


    public function clientAppointments($contactId)
    {
        $user = Auth::user();
        // Fetch all services for the authenticated user
        try {
            $appointments = Appointment::where('user_id', $user->id)->where('contact_id', $contactId)->orderBy('id', 'DESC')->get();

            if ($appointments->isEmpty()) {
                return response()->json(['message' => 'No appointment found', 'status' => false], 200);
            }
            $projects = AppointmentResource::collection($appointments);
            return response()->json([
                'status' => true,
                'data' => $appointments,
            ], 200);

        } catch (\Exception $e) {
           return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }
    }



    public function showSetAvailability()
    {
        $user = Auth::user();
        // Fetch all weekly schedule rules
        $schedule = Availability::orderBy('id')->where('user_id', $user->id)->get(); // Order by ID to keep Sunday first

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


    public function updateStatus(Request $request, $id): JsonResponse
    {
        // 2. Validation: Ensure a valid status is provided.
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(AppointmentStatus::values())],
        ]);

        $appointment = Appointment::find($id);
        if(!$appointment){
            return response()->json([
                'status' => false,
                'message' => 'Appointment not found.',
            ], 200);
        }


        // Update the appointment
        $appointment->update([
            'appointment_status' => $validated['status'],
        ]);


        return response()->json([
            'status' => true,
            'message' => 'Appointment status updated successfully.',
            'data' => $appointment,
        ], 200);
    }

    public function reschedule(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'date' => ['required', 'date_format:Y-m-d'],
            'time' => ['required', 'date_format:H:i'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status'  => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $appointment = Appointment::find($id);
        if(!$appointment){
            return response()->json([
                'status' => false,
                'message' => 'Appointment not found.',
            ], 200);
        }

        // 3. Update the date, time, and status.
        $appointment->update([
            'date' => $request->input('date'),
            'time' => $request->input('time'),
            'appointment_status' => 'Rescheduled', // Automatically update the status
        ]);

        // 4. Return the updated appointment.
        return response()->json([
            'status' => true,
            'message' => 'Appointment rescheduled successfully.',
            'data' => $appointment,
        ], 200);
    }



    public function uploadDocument(Request $request)
    {
        return $this->handleDocumentStore($request);
    }
}
