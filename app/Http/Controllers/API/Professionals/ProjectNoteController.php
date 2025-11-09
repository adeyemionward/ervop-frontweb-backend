<?php

namespace App\Http\Controllers\API\Professionals;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectNoteController extends Controller
{
    public function index(Project $project)
    {
        try {
            // Eager load user relation (only id + firstname)
            $projectNotes = ProjectNote::with('user:id,firstname,lastname')
                ->where('project_id', $project->id)
                ->get();

            if ($projectNotes->isEmpty()) {
                return response()->json([
                    'message' => 'No notes found for this project',
                    'status' => false
                ], 200);
            }

            // Map notes into clean structure
            $notes = $projectNotes->map(function ($note) {
                return [
                    'id' => $note->id,
                    'content' => $note->content,
                    'author' => $note->user->firstname .' '. $note->user->lastname ?? 'Unknown',
                    'created_at' => $note->created_at,
                    'updated_at' => $note->updated_at,
                ];
            });

            return response()->json([
                'status' => true,
                'data' => $notes,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred',
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function store(Request $request, project $project)
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


        $note = $project->notes()->create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        // ✅ Load user relation and include firstname
        $note->load('user:id,firstname');

        return response()->json([
            'id' => $note->id,
            'content' => $note->content,
            'author' => $note->user->firstname ?? 'Unknown',
            'created_at' => $note->created_at,
            'updated_at' => $note->updated_at,
        ], 201);
    }

    /**
     * Update an existing project note.
    */

    public function update(Request $request, projectNote $note)
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
     * Remove the specified project note from storage.
    */
    public function destroy(projectNote $note)
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

