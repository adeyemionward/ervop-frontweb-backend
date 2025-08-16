<?php

namespace App\Http\Controllers\API\Professionals;

use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use App\Traits\HandleFileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DocumentController extends Controller
{

    use HandleFileUpload;
    public function index(){
        $user = Auth::user();
        // Fetch all projects for the authenticated user
        try {
            // Get the IDs of the latest documents for each contact_id
            // Subquery to find the latest document ID and count for each contact_id
            $subQuery = Document::select(
                'contact_id',
                DB::raw('MAX(id) as latest_id'),
                DB::raw('COUNT(id) as count') // Add the count here
            )
            ->where('user_id', $user->id)
            ->groupBy('contact_id');

            // Main query to fetch the full document details
            $documents = Document::with([
                'project:id,title',
                'customer:id,firstname,lastname,email,phone',
            ])
            // Join the main table with the subquery results
            ->joinSub($subQuery, 'latest_documents', function ($join) {
                $join->on('documents.id', '=', 'latest_documents.latest_id');
            })
            // Select all original document columns and the new 'count'
            ->select('documents.*', 'latest_documents.count')
            ->orderBy('id', 'DESC')
            ->get();

            if ($documents->isEmpty()) {
                return response()->json(['message' => 'No document found', 'status' => false], 200);
            }
            $documents = DocumentResource::collection($documents);
            return response()->json([
                'status' => true,
                'data' => $documents,
            ], 200);

        } catch (\Exception $e) {
           return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }

    }

    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'contact_id' => ['nullable','integer',Rule::exists('contacts', 'id')],
            'project_id' => ['nullable','integer',Rule::exists('projects', 'id')],
            'title' => ['required', 'string'],
            'business_docs' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg,pdf', 'max:2048'],
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
            if ($request->hasFile('business_docs')) {
                $businessDocs = $this->handleFileUploadImage($request->hasFile('business_docs'), $request->file('business_docs'), 'business_docs');
                $baseUrl = config('app.url');
                $businessDocsPath = $baseUrl . '/' . $businessDocs;
            }

            $document = new Document([
                'user_id'       => Auth::user()->id,
                'contact_id'    => $request->input('contact_id') ?? NULL,
                'project_id'    => $request->input('project_id') ?? NULL,
                'title'         => $request->input('title'),
                'document_path' => $businessDocsPath,
                'tags'          => $request->input('tags'),
            ]);
            $document->save();
            // You can customize the success response as needed
            return response()->json([
                'message' => 'Document created successfully',
                'status' => true,
                'data' => $document,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id){
        try {
            $documents = Document::with([
                'project:id,title',
                'customer:id,firstname,lastname,email,phone',
            ])->where('contact_id', $id)->get();

            if ($documents->isEmpty()) {
                return response()->json(['message' => 'No document found', 'status' => false], 200);
            }

            $documents = DocumentResource::collection($documents);
            return response()->json([
                'status' => true,
                'data' => $documents,
            ], 200);

        } catch (\Exception $e) {
           return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
