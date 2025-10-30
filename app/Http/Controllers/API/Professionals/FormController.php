<?php

namespace App\Http\Controllers\API\Professionals;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
class FormController extends Controller
{

    public function index()
    {
        $forms = Form::where('user_id', Auth::user()->id)->latest()->get();
        return response()->json($forms);
    }

    /**
     * Store a newly created form and its fields in storage.
     */
    public function create(Request $request)
    {
        $validated = $this->validateRequest($request);

        $form = DB::transaction(function () use ($validated) {
            // Create the parent form
            $form = Form::create([
                'user_id' => Auth::user()->id, // Replace with auth()->id()
                'title' => $validated['title'],
            ]);

            // Create the associated fields with the correct order

            if (!empty($validated['fields'])) {
                foreach ($validated['fields'] as $index => $fieldData) {
                    // **THE FIX IS HERE:** Add the user_id to each field
                    $form->fields()->create($fieldData + [
                        'order' => $index,
                        'user_id' => Auth::user()->id // This line was missing
                    ]);
                }
            }

            return $form;
        });

        return response()->json($form->load('fields'), 201);
    }

    /**
     * Display the specified form with its fields.
     */
    public function show(Form $form)
    {
        // Add authorization check here in a real app
        return response()->json($form->load('fields'));
    }

   public function update(Request $request, Form $form)
{


    $validated = $this->validateRequest($request);

    DB::transaction(function () use ($form, $validated) {
        // 1. Update the form's title
        $form->update(['title' => $validated['title']]);

        $incomingFieldIds = [];

        // 2. Loop through the fields sent from the frontend
        if (!empty($validated['fields'])) {
            foreach ($validated['fields'] as $index => $fieldData) {
                // Prepare the data for this field
                $dataToSave = [
                    'user_id'       => Auth::user()->id,
                    'label'       => $fieldData['label'] ?? null,
                    'type'        => $fieldData['type'] ?? null,
                    'placeholder' => $fieldData['placeholder'] ?? null,
                    'required'    => $fieldData['required'] ?? null,
                    'options'     => $fieldData['options'] ?? null,
                    'order'       => $index,
                ];

                if (isset($fieldData['id'])) {
                    // If the field has an ID, it's an existing field. Update it.
                    $field = $form->fields()->find($fieldData['id']);
                    if ($field) {
                        $field->update($dataToSave);
                        $incomingFieldIds[] = $field->id;
                    }
                } else {
                    // If the field has no ID, it's a new field. Create it.
                    $newField = $form->fields()->create($dataToSave);
                    $incomingFieldIds[] = $newField->id;
                }
            }


        }

        // 3. Delete any fields that are no longer in the incoming request
        $form->fields()->whereNotIn('id', $incomingFieldIds)->delete();
    });

    return response()->json($form->fresh()->load('fields'));
}
     public function delete($id)
    {
        $invoice = Form::find($id);

        if (!$invoice) {
            return response()->json([
                'status' => false,
                'message' => 'Form not found.',
            ], 200);
        }
        $delete =  $invoice->delete();
        if($delete){
            return response()->json([
            'status' => true,
            'message'   => 'Form deleted',
        ], 200);
        }

    }

    /**
     * Centralized validation logic for store and update.
     */
    private function validateRequest(Request $request): array
    {
        $fieldTypes = ['text', 'textarea', 'tel', 'number', 'dropdown', 'checkbox', 'radio', 'date', 'time'];

        return $request->validate([
            'title' => 'required|string|max:255',
            'fields' => 'present|array',
            'fields.*.id' => 'nullable|integer', // Allow null for new fields
            'fields.*.label' => 'required|string|max:255',
            'fields.*.type' => ['required', Rule::in($fieldTypes)],
            'fields.*.placeholder' => 'nullable|string|max:255',
            'fields.*.required' => 'required|boolean',
            'fields.*.options' => 'nullable|array',
        ]);


    }
}

