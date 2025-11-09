<?php

namespace App\Http\Controllers\API\Professionals;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\ProjectResource;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\ProjectTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Fetch all services for the authenticated user
        try {
            $projects = Project::with([
                'service:id,name',
                'customer:id,firstname,lastname,email,phone',
            ])->where('user_id', $user->id)->orderBy('id', 'DESC')->get();

            if ($projects->isEmpty()) {
                return response()->json(['message' => 'No client work or project found', 'status' => false], 200);
            }
            $projects = ProjectResource::collection($projects);
            return response()->json([
                'status' => true,
                'data' => $projects,
            ], 200);

        } catch (\Exception $e) {
           return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }

    }

    public function create(Request $request)
    {
        // Validate the request data

        $validator = Validator::make($request->all(), [
            'contact_id' => ['required', 'integer', Rule::exists('contacts', 'id')],
            'service_id' => ['required', 'integer', Rule::exists('services', 'id')],
            'start_date' => ['nullable', 'string'],
            'end_date' => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'cost' => ['required', 'numeric'],
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status'=>false,
                'errors' => $validator->errors()
            ], 422);
        }

        $randomSecure = bin2hex(random_bytes(16)); // Generate a secure random string

        try {
            $project = DB::transaction(function () use ($request, $randomSecure) {
                $project = new Project([
                    'client_project_id' => $randomSecure,
                    'user_id'       => Auth::user()->id,
                    'contact_id'    => $request->input('contact_id'),
                    'service_id'    => $request->input('service_id'),
                    'title'         => $request->input('title'),
                    'cost'          => $request->input('cost'),
                    'start_date'    => $request->input('start_date'),
                    'end_date'      => $request->input('end_date'),
                    'status'        => $request->input('status'),
                    'description'   => $request->input('description'),
                ]);
                $project->save();

                // Then, insert the new ones
                if ($request->has('tasks') && is_array($request->tasks)) {
                    $tasksToInsert = [];
                    foreach ($request->tasks as $task) {
                        // Skip any empty task fields from the form
                        if (!empty($task)) {
                            $tasksToInsert[] = [
                                'user_id'    => Auth::user()->id,
                                'contact_id' => $request->input('contact_id'),
                                'project_id' => $project->id,
                                'task'       => $task,
                                'created_at' => now(), // Add timestamps for insert
                                'updated_at' => now(),
                            ];
                        }
                    }

                    if (!empty($tasksToInsert)) {
                        ProjectTask::insert($tasksToInsert);
                    }
                }
                return $project;
            });

            // You can customize the success response as needed
            return response()->json([
                'message' => 'Project created successfully',
                'status' => true,
                'data' => $project,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function show(Project $project)
    {
        try {
            // return $project->user_id.'--'. Auth::id();
            // 1. Authorization
            if ($project->user_id !== Auth::id()) {
                return response()->json([
                    'message' => 'Unauthorized',
                    'status'  => false,
                ], 403);
            }

            // 2. Eager-load relationships
            $project->load([
                'service:id,name',
                'customer:id,firstname,lastname,email,phone',
                // 'notesHistory:id,project_id,content,created_at',
                'notesHistory.user:id,firstname,lastname',
                'invoices.items',
                'invoices.payments',
                'documents.files',
            ]);

            // 3. Format response
            $data = [
                'id'                => $project->id,
                'user_id'           => $project->user_id,
                'contact_id'        => $project->contact_id,
                'service_id'        => $project->service_id,
                'date'              => $project->date,
                'time'              => $project->time,
                'amount'            => $project->amount,
                'project_status'=> $project->project_status,
                'notesHistory' => $project->notesHistory ? $project->notesHistory->map(function ($note) {
            return [
                'id'             => $note->id,
                'project_id' => $note->project_id,
                'content'        => $note->content,
                'author'         => $note->user->firstname . ' ' . $note->user->lastname ?? 'Unknown', // ✅ include user firstname
                'created_at'     => $note->created_at,
            ];
        }) : [],

                'created_at'        => $project->created_at,
                'updated_at'        => $project->updated_at,
                'service'           => $project->service,
                'customer'          => $project->customer,
                'invoices'          => $project->invoices ? $project->invoices->map(function ($invoice) {
                    return [
                        'id'                  => $invoice->id,
                        'user_id'             => $invoice->user_id,
                        'contact_id'          => $invoice->contact_id,
                        'project_id'          => $invoice->project_id,
                        'project_id'      => $invoice->project_id,
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
                'documents' => $project->documents ? $project->documents->map(function ($doc) {
                    return [
                        'id'           => $doc->id,
                        'user_id'      => $doc->user_id,
                        'contact_id'   => $doc->contact_id,
                        'project_id'   => $doc->project_id,
                        'project_id'=> $doc->project_id,
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

    public function clientProjects($contactId)
    {
        $user = Auth::user();
        // Fetch all services for the authenticated user
        try {
            $projects = Project::where('user_id', $user->id)->where('contact_id', $contactId)->orderBy('id', 'DESC')->get();

            if ($projects->isEmpty()) {
                return response()->json(['message' => 'No client work or project found', 'status' => false], 200);
            }
            $projects = ProjectResource::collection($projects);
            return response()->json([
                'status' => true,
                'data' => $projects,
            ], 200);

        } catch (\Exception $e) {
           return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }
    }



}
