<?php

namespace App\Http\Controllers\ClientPortal\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class OverviewController extends Controller
{
    public function index($username, $cprojectId)
    {
        $project = Project::where('client_project_id', $cprojectId)->first();

        if (!$project) {
            return response()->view('errors.project_errors', [
                'message' => 'The project ID "' . $cprojectId . '" does not exist in our system.',
            ], 404);
        }

        // Eager-load all relationships
        $project->load([
            'service:id,name',
            'customer:id,firstname,lastname,email,phone',
            'notesHistory.user:id,firstname,lastname',
            'quotations.items',
            'invoices.items',
            'invoices.payments',
            'documents.files',
        ]);

        // Format notes for Blade
        $notesHistory = $project->notesHistory->map(function ($note) {
            return [
                'id' => $note->id,
                'project_id' => $note->project_id,
                'content' => $note->content,
                'author' => $note->user ? $note->user->firstname . ' ' . $note->user->lastname : 'Unknown',
                'created_at' => $note->created_at,
            ];
        });

        // Format documents (including files)
        $documents = $project->documents->map(function ($doc) {
            return [
                'id'         => $doc->id,
                'title'      => $doc->title,
                'type'       => $doc->type ?? 'N/A',
                'created_at' => $doc->created_at,
                // If you want the latest file info to display:
                'file' => $doc->files->sortByDesc('created_at')->first() ? [
                    'file_path' => $doc->files->sortByDesc('created_at')->first()->file_path,
                    'status'    => $doc->files->sortByDesc('created_at')->first()->status ?? 'Pending',
                    'file_type' => $doc->files->sortByDesc('created_at')->first()->file_type,
                ] : null,
            ];
        });

        return view('portal.project.index', [
            'project' => $project,
            'notesHistory' => $notesHistory,
            'documents' => $documents,
        ]);
    }


}
