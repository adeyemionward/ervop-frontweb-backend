<?php

namespace App\Http\Controllers\API\Professionals;

use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentFileResource;
use App\Http\Resources\DocumentResource;
use App\Models\Contact;
use App\Models\Document;
use App\Models\DocumentFile;
use App\Traits\HandleFileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DocumentController extends Controller
{

    use HandleFileUpload;


    public function index()
    {
        $user = Auth::user();

        try {
            // Subquery to get the latest document per contact with count
            $subQuery = DocumentFile::select(
                'contact_id',
                DB::raw('MAX(id) as latest_id'),
                DB::raw('COUNT(id) as count')
            )
            ->groupBy('contact_id');

            // Fetch all latest documents
            $documents = DocumentFile::with([
                    'customer:id,firstname,lastname,email,phone',
                ])
                ->joinSub($subQuery, 'latest_documents', function ($join) {
                    $join->on('document_files.id', '=', 'latest_documents.latest_id');
                })
                ->select('document_files.*', 'latest_documents.count')
                ->orderBy('id', 'DESC')
                ->get();

            if ($documents->isEmpty()) {
                return response()->json([
                    'message' => 'No document found',
                    'status' => false
                ], 200);
            }

            // Calculate counts directly
            $myDocuments = $documents->where('contact_id', NULL)->values();
            $clientDocuments = $documents->where('contact_id', '!=', $user->id)->where('contact_id', '!=', NULL)->values();

            $response = [
                'status' => true,
                'my_documents' => DocumentFileResource::collection($myDocuments),
                'client_documents' => DocumentFileResource::collection($clientDocuments),
            ];

            return response()->json($response, 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred',
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'contact_id' => ['nullable'],
            'project_id' => ['nullable'],
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

        $type = null;
        if ($request->input('type') != 'General') {
            $type = 'Sent';
        }

        try {
            $document = Document::create([
                'user_id'       => Auth::id(),
                'type'          => $request->input('type'),
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
                        'status'        => $type,
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

    public function userDocs($id)
    {
        try {
            // First try by contact_id (clients)
            $documentsFiles = DocumentFile::with('document')
            ->where('contact_id', $id)
            ->get();

            // If none found, try by document_id (business)
            if ($documentsFiles->isEmpty()) {
                $documentsFiles = DocumentFile::where('contact_id',NULL)->where('user_id',  Auth::id())->get();
            }

            if ($documentsFiles->isEmpty()) {
                return response()->json(['message' => 'No document found', 'status' => false], 200);
            }
                    
            return response()->json([
                'status' => true,
                'data' => DocumentFileResource::collection($documentsFiles),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occured',
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // public function clientsWithDocs(){
    //     try {
    //         $user = Auth::user();
    //         // Get distinct contact IDs from document_files for the authenticated user
    //         $contactIds = Document::where('user_id', $user->id)
    //             ->whereNotNull('contact_id')
    //             ->distinct()
    //             ->pluck('contact_id');

    //         if ($contactIds->isEmpty()) {
    //             return response()->json(['message' => 'No clients with documents found', 'status' => false], 200);
    //         }

    //         // Fetch contacts based on the retrieved IDs
    //         $contacts = Contact::whereIn('id', $contactIds)->get();

    //         return response()->json([
    //             'status' => true,
    //             'data' => $contacts,
    //         ], 200);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Error occured',
    //             'status' => false,
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function update(Request $request, $id)
    {
        $document = Document::with('files')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'contact_id' => ['nullable','integer',Rule::exists('contacts', 'id')],
            'project_id' => ['nullable','integer',Rule::exists('projects', 'id')],
            'appointment_id' => ['nullable','integer',Rule::exists('appointments', 'id')],
            'title' => ['required', 'string'],
            'tags' => ['nullable', 'string'],
            'business_docs.*' => ['file','mimes:jpeg,png,jpg,gif,svg,pdf','max:2048'],
            'remove_file_ids' => ['nullable','array'], // array of file IDs to remove
            'remove_file_ids.*' => ['integer', Rule::exists('document_files','id')],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // 1. Remove selected files
            if ($request->has('remove_file_ids')) {
                $filesToRemove = DocumentFile::whereIn('id', $request->remove_file_ids)->get();
                foreach ($filesToRemove as $file) {
                    $filePath = public_path(str_replace(config('app.url') . '/', '', $file->file_path));
                    if (file_exists($filePath)) {
                        unlink($filePath); // delete file from public folder
                    }
                    $file->delete(); // remove from database
                }
            }

            // 2. Upload new files
            if ($request->hasFile('business_docs')) {
                foreach ($request->file('business_docs') as $file) {
                    $fileName = time() . '_' . str_replace(' ', '', $file->getClientOriginalName());
                    $file->move(public_path('business_docs/'), $fileName);

                    $document->files()->create([
                        'user_id'   => Auth::id(),
                        'file_path' => config('app.url') . '/business_docs/' . $fileName,
                        'file_type' => $file->getClientMimeType(),
                    ]);
                }
            }

            // 3. Update document fields
            $document->update([
                'title' => $request->input('title'),
                'contact_id' => $request->input('contact_id'),
                'project_id' => $request->input('project_id'),
                'appointment_id' => $request->input('appointment_id'),
                'tags' => $request->input('tags'),
            ]);

            return response()->json([
                'message' => 'Document updated successfully',
                'status' => true,
                'data' => $document->load('files')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred',
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            // Find the single document file
            $documentFile = DocumentFile::findOrFail($id);

            // Build the absolute path to the file in public folder
            $filePath = public_path(str_replace(config('app.url') . '/', '', $documentFile->file_path));

            // Delete physical file if it exists
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete DB record
            $documentFile->delete();

            return response()->json([
                'message' => 'Document file deleted successfully',
                'status'  => true
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred',
                'status'  => false,
                'error'   => $e->getMessage()
            ], 500);
        }
    }

}
