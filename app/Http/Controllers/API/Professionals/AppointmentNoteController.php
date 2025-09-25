<?php

namespace App\Http\Controllers\API\Professionals;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AppointmentNoteController extends Controller
{
    public function index(Appointment $appointment)
    {
        $user = Auth::user();
        // Fetch all services for the authenticated user
        try {
            $appointmentNote = AppointmentNote::where('appointment_id', $appointment->id)->get();

            if ($appointmentNote->isEmpty()) {
                return response()->json(['message' => 'No appointment found', 'status' => false], 200);
            }

            return response()->json([
                'status' => true,
                'data' => $appointmentNote,
            ], 200);

        } catch (\Exception $e) {
           return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }

    }

    public function store(Request $request, Appointment $appointment)
    {


        $validator = Validator::make($request->all(), [
            'content' => ['required', 'string'],
        ]);

         if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status'=>false,
                'errors' => $validator->errors()
            ], 422);
        }


        $note = $appointment->notes()->create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        return response()->json($note, 201);
    }

    /**
     * Update an existing appointment note.
     */

    public function update(Request $request, AppointmentNote $note)
    {
        $validator = Validator::make($request->all(), [
            'content' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status'  => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        // The fix is here: Use the validated data, which is an array.
        $note->update($validator->validated());

        return response()->json($note);
}

    /**
     * Delete an appointment note.
     */
   /**
 * Remove the specified appointment note from storage.
 */
public function destroy(AppointmentNote $note)
{
    $isDeleted = $note->delete();

    if ($isDeleted) {
        return response()->json([
            'message' => 'Note deleted successfully',
            'status' => true
        ], 200);
    }

    // This handles the rare case where the deletion fails for some reason.
    return response()->json([
        'message' => 'Failed to delete the note',
        'status' => false
    ], 500); // 500 Internal Server Error
}
}

