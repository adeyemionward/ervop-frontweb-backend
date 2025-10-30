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

        try {
            $project = DB::transaction(function () use ($request) {
                $project = new Project([
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

    public function show($id)
    {

        try {
            $project = Project::where('user_id', Auth::id())->where('id', $id)->first();
            if (is_null($project)) {
                return response()->json(['message' => 'No Project found', 'status' => false], 200);
            }

            return response()->json([
                'status' => true,
                'project' => $project,
            ], 200);

        } catch (\Exception $e) {
           return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
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
