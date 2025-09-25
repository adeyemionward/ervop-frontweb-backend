<?php

namespace App\Http\Controllers\API\Professionals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenAI\OpenAI;

class OpenAiController extends Controller
{
     public function generateTasks(Request $request)
    {
        $request->validate([
            'projectTitle' => 'required|string|max:255',
        ]);

        $projectTitle = $request->projectTitle;

        try {
            $client = new OpenAI(env('OPENAI_API_KEY'));

            $response = $client->chat()->create([
                'model' => 'gpt-4',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "Create a list of 5 project tasks based on this title: \"$projectTitle\". Return only a JSON array of strings."
                    ],
                ],
                'max_tokens' => 150,
            ]);

            $text = $response->choices[0]->message->content ?? '[]';

            // Safe JSON parse
            $tasks = json_decode($text, true);
            if (!is_array($tasks)) {
                $tasks = [$text]; // fallback
            }

            return response()->json(['tasks' => $tasks]);
        } catch (\Exception $e) {
            \Log::error("AI task generation failed: " . $e->getMessage());
            return response()->json(['error' => 'Failed to generate AI tasks'], 500);
        }
    }
}



