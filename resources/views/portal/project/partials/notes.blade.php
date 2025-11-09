<div id="notes" class="tab-pane hidden">
                <h3 class="text-xl font-bold mb-4">Notes & Feedback</h3>
                <div class="space-y-3 mb-6">
                    @forelse ($project->notesHistory as $note)
                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                        <p class="text-gray-700">{{ $note['content'] }}</p>
                        <p class="text-xs text-gray-500 mt-2">— {{ $note['author'] }}, {{ \Carbon\Carbon::parse($note['created_at'])->format('M d, Y') }}</p>
                    </div>
                    @empty
                    <p class="text-gray-500">No notes yet.</p>
                    @endforelse
                </div>
                <form method="POST" action="">
                    @csrf
                    <textarea name="content" placeholder="Add a new note..." class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-500 focus:outline-none"></textarea>
                    <button type="submit" class="mt-3 px-5 py-2 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition">Add Note</button>
                </form>
                </div>
            </div>
