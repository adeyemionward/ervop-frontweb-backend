<?php

namespace App\Http\Controllers\API\Professionals;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail; // For sending emails
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FormSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function submitForm(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'form_id'    => 'required|exists:forms,id',
            'project_id' => 'required|exists:projects,id',
            'contact_id' => 'required|exists:contacts,id',
            'action'     => 'required|in:send_to_client,fill_on_behalf',
            'answers'    => 'required_if:action,fill_on_behalf|array',

            'answers.*.form_field_id' => 'required_with:answers|exists:form_fields,id',
            'answers.*.value'         => 'required_with:answers|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status'=>false,
                'errors' => $validator->errors()
            ], 422);
        }

        $submission = DB::transaction(function () use ($request) {
            // ✅ Update the form (don’t create a new one)
            Form::where('id', $request->input('form_id'))
            ->increment('submissions_count', 1, ['last_used' => now()]);

            if ($request->input('action') === 'fill_on_behalf') {
                // --- ACTION: FILL ON BEHALF ---
                $submission = FormSubmission::create([
                    'form_id'      => $request->input('form_id'),
                    'project_id'   => $request->input('project_id'),
                    'contact_id'   => $request->input('contact_id'),
                    'user_id'      => Auth::user()->id,
                    'status'       => 'completed',
                    'submitted_at' => now(),
                    'answers'      => $request->input('answers'), // Save answers directly
                ]);

            } else {
                // --- ACTION: SEND TO CLIENT ---
                $submission = FormSubmission::create([
                    'form_id'      => $request->input('form_id'),
                    'project_id'   => $request->input('project_id'),
                    'contact_id'   => $request->input('contact_id'),
                    'user_id'    => Auth::user()->id,
                    'status'     => 'pending',
                    'token'      => Str::random(40), // Generate secure token
                ]);

                // TODO: Dispatch an email to the client
                // Mail::to($submission->contact->email)->send(new SendFormLinkMail($submission));
            }

            return $submission;
        });

        return response()->json($submission, 201);
    }

    public function listFormSubmissions(Request $request, Form $form): JsonResponse
    {
        // Add authorization check to ensure the user owns this form
        // abort_if($form->user_id !== auth()->id(), 403);

        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        // **1. Get the headers (the fields/questions) for this specific form**
        $headers = $form->fields()->orderBy('order')->get();

        // 2. Start the base query for submissions related to this form
        $query = $form->submissions()->with(['contact', 'project']);

        // 3. Apply dynamic search if a search term is provided
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');

            $query->where(function ($q) use ($searchTerm) {
                // Search in the standard fields (Contact Name and Project Title)
                $q->whereHas('contact', function ($contactQuery) use ($searchTerm) {
                    $contactQuery->where('firstname', 'like', "%{$searchTerm}%")
                                ->orWhere('lastname', 'like', "%{$searchTerm}%");
                })
                ->orWhereHas('project', function ($projectQuery) use ($searchTerm) {
                    $projectQuery->where('title', 'like', "%{$searchTerm}%");
                });

                // **THE FIX IS HERE:**
                // Use a standard 'like' query on the JSON column.
                // This will find the search term anywhere inside the answers data.
                $q->orWhere('answers', 'like', "%{$searchTerm}%");
            });
        }

        // 4. Paginate the results for performance
        $submissions = $query->latest('submitted_at')->paginate(20);

        // **5. Return BOTH headers and submissions in a single JSON response**
        return response()->json([
            'headers' => $headers,
            'submissions' => $submissions,
        ]);
    }

    public function viewFormSubmissions(FormSubmission $submission)
    {
        // Eager-load all the necessary relationships
        $submission->load(['contact', 'project', 'form.fields']);

        return response()->json($submission);
    }

    public function updateFormSubmissions(Request $request, FormSubmission $submission): JsonResponse
    {
        // Add your authorization check here
        // abort_if($submission->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*.form_field_id' => 'required|exists:form_fields,id',
            'answers.*.value' => 'nullable|string', // Value can be null or empty
        ]);

        $submission->update([
            'answers' => $validated['answers'],
        ]);

        return response()->json($submission->fresh());
    }
}
