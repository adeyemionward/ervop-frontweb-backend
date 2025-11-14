<?php

namespace App\Http\Controllers\ClientPortal\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class DocumentController extends Controller
{
     public function newDocument(Request $request, $username, $cprojectId){
       /// dd($cprojectId);

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'type' => [
                'required',
                'string',
                Rule::in(['Proposal', 'Contract', 'NDA', 'General']),
            ],

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

        $project =  Project::where('client_project_id', $cprojectId)->first();

        $projectId = $project->id;
        $userId = $project->user_id;
        $contactId = $project->contact_id;

        $type = null;
        if ($request->input('type') != 'General') {
            $type = 'Sent';
        }

        try {
            $document = Document::create([
                'user_id'       => $userId,
                'type'          => $request->input('type'),
                'contact_id'    => $contactId,
                'project_id'    => $projectId,
                'title'         => $request->input('title'),
                'tags'          => $request->input('tags'),
            ]);

            if ($request->hasFile('business_docs')) {
                foreach ($request->file('business_docs') as $file) {
                    $fileName = time() . '_' . str_replace(' ', '', $file->getClientOriginalName());
                    $file->move(public_path('business_docs/'), $fileName);

                    $document->files()->create([
                        'user_id'       => $userId,
                        'contact_id'    => $contactId,
                        'file_path'     => config('app.url') . '/business_docs/' . $fileName,
                        'file_type'     => $file->getClientMimeType(),
                        'status'        => $type,
                    ]);
                }
            }

            // You can customize the success response as needed
            return response()->json([
                'message' => 'Document created successfully',
                'status' => true,
                'username' => $username,
                'project' => $project,
                'cprojectId' => $cprojectId,
                'data' => $document->load('files'),
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }
    }

//     public function reloadDocuments($username, $cprojectId)
// {
//     $project = Project::where('client_project_id', $cprojectId)
//         ->with(['documents.files'])
//         ->first();

//     if (!$project) {
//         return response('<p class="text-gray-500">Project not found.</p>', 404);
//     }

//     $documents = $project->documents->map(function ($doc) {
//         return [
//             'id' => $doc->id,
//             'title' => $doc->title,
//             'type' => $doc->type ?? 'N/A',
//             'created_at' => $doc->created_at,
//             'file' => $doc->files->sortByDesc('created_at')->first() ? [
//                 'file_path' => $doc->files->sortByDesc('created_at')->first()->file_path,
//                 'status' => $doc->files->sortByDesc('created_at')->first()->status ?? 'Pending',
//             ] : null,
//         ];
//     });

//     // 🔁 Return *only* the inside of the .space-y-3 div
//     return view('portal.project.partials.documents', compact('documents','project'))->render();
// }

public function reloadDocuments($username, $cprojectId)
{
    // Find the project using the public client_project_id
    $project = Project::where('client_project_id', $cprojectId)
        ->with(['documents.files'])
        ->first();

    if (!$project) {
        return response("<p class='text-red-500'>Project not found.</p>", 404);
    }

    // Transform the documents for easier Blade rendering
    $documents = $project->documents->map(function ($doc) {
        $latestFile = $doc->files->sortByDesc('created_at')->first();

        return [
            'id'         => $doc->id,
            'title'      => $doc->title,
            'type'       => $doc->type ?? 'N/A',
            'created_at' => $doc->created_at,
            'file'       => $latestFile ? [
                'file_path' => $latestFile->file_path,
                'status'    => $latestFile->status ?? 'Pending',
            ] : null,
        ];
    });

    // ✅ Return only the inner document list partial
    // The `.render()` ensures the controller returns raw HTML instead of a full view response object
    return view('portal.project.partials.reload_doc_list', compact('documents', 'project'))->render();
}


}
