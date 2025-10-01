<?php

namespace App\Traits;

use App\Models\Document;
use App\Models\Project;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
trait HandleUploadDocuments
{
    /**
     * Store documents and resolve contact_id from project or appointment.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleDocumentStore(Request $request)
    {
        $request->validate([
            'title'           => 'required|string',
            'project_id'      => 'nullable|integer|exists:projects,id',
            'appointment_id'  => 'nullable|integer|exists:appointments,id',
            'business_docs.*' => 'required|file|max:10240', // 10MB each
        ]);

        $projectId     = $request->input('project_id');
        $appointmentId = $request->input('appointment_id');
        $contactId     = null;

        // 🔹 Resolve contact_id
        if ($projectId) {
            $project   = Project::findOrFail($projectId);
            $contactId = $project->contact_id;
        } elseif ($appointmentId) {
            $appointment = Appointment::findOrFail($appointmentId);
            $contactId   = $appointment->contact_id;
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Either project_id or appointment_id is required',
            ], 422);
        }

        if ($request->hasFile('business_docs')) {
            $document = Document::create([
                'user_id'       => Auth::id(),
                'contact_id'    => $contactId ,
                'project_id'    => $request->input('project_id') ?? NULL,
                'appointment_id'=> $request->input('appointment_id') ?? NULL,
                'title'         => $request->input('title'),
                'tags'          => $request->input('tags'),
            ]);
            foreach ($request->file('business_docs') as $file) {
                $fileName = time() . '_' . str_replace(' ', '', $file->getClientOriginalName());
                $file->move(public_path('business_docs/'), $fileName);

                $document->files()->create([
                    'user_id'       => Auth::id(),
                    'contact_id'    => $contactId ,
                    'file_path'     => config('app.url') . '/business_docs/' . $fileName,
                    'file_type'     => $file->getClientMimeType(),
                ]);
            }
        }

        return response()->json([
            'message' => 'Document created successfully',
            'status' => true,
            'data' => $document->load('files'),
        ], 201);
    }
}
