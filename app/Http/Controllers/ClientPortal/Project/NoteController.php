<?php

namespace App\Http\Controllers\ClientPortal\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function newNote(Request $request, $username, $cprojectId)
{
    $request->validate([
        'content' => 'required|string',
    ]);

    $project = Project::where('client_project_id', $cprojectId)->firstOrFail();

    $note = ProjectNote::create([
        'user_id'    => $project->user_id,
        'project_id' => $project->id,
        'content'    => $request->input('content'),
    ]);

    $note->load('user:id,firstname,lastname');

    return response()->json([
        'id'         => $note->id,
        'content'    => $note->content,
        'author'     => $note->user->firstname ?? 'Unknown',
        'created_at' => $note->created_at,
    ], 201);
}

public function reloadNotes($username, $cprojectId)
{
    $project = Project::where('client_project_id', $cprojectId)
        ->with(['notesHistory.user:id,firstname,lastname'])
        ->firstOrFail();

    $notes = $project->notesHistory->map(function ($note) {
        return view('portal.project.partials.reload_notes_list', ['note' => [
            'content' => $note->content,
            'author'  => $note->user->firstname ?? 'Unknown',
            'created_at' => $note->created_at,
            'notes' => $note->notes,
        ]])->render();
    })->implode('');

    return response($notes);
}

}
