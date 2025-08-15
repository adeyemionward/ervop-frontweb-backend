<?php

namespace App\Http\Controllers\API\Professionals;

use App\Enum\ContactStatus;
use App\Enum\ServiceStatus;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        // Fetch all services for the authenticated user
        try {
            $contact = Contact::where('user_id', Auth::id())->get();
            if ($contact->isEmpty()) {
                return response()->json(['message' => 'No contact found', 'status' => false], 200);
            }

            return response()->json([
                'status' => true,
                'data' => $contact,
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
            'phone' => ['required', 'string', 'max:255', 'unique:contacts'],
            'company' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
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
            $contact = new Contact([
                'user_id'   => Auth::user()->id,
                'firstname' => $request->input('firstname'),
                'lastname'  => $request->input('lastname'),
                'email'     => $request->input('email'),
                'phone'     => $request->input('phone'),
                'company'   => $request->input('company'),
                'status'    => 'active',
                'tags'      => $request->input('tags'),
            ]);
            $contact->save();
            // You can customize the success response as needed
            return response()->json([
                'message' => 'Contact created successfully',
                'status' => true,
                'data' => $contact,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
