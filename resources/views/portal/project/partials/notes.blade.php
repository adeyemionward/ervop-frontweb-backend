
<meta name="csrf-token" content="{{ csrf_token() }}">
<div id="notes" class="tab-pane hidden">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold text-gray-900">Notes & Feedback</h3>
        <!-- Add Note Button -->
        <button id="openNoteModal" class="px-4 py-2 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 font-medium">
            Add Note
        </button>
    </div>

    <div class="space-y-3 mb-6" id="notesContainer">
        @forelse ($project->notesHistory as $note)
            <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                <p class="text-gray-700">{{ $note['content'] }}</p>
                <p class="text-xs text-gray-500 mt-2">— {{ $note['author'] }}, {{ \Carbon\Carbon::parse($note['created_at'])->format('M d, Y') }}</p>
            </div>
        @empty
            <p class="text-gray-500">No notes yet.</p>
        @endforelse
    </div>
</div>
<div id="noteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-2xl w-full max-w-lg p-6 relative">
        <button id="closeNoteModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        <h3 class="text-lg font-bold mb-4">Add a New Note</h3>

        <form id="addNoteForm" data-project-id="{{ $project->client_project_id }}">
            @csrf
            <div class="mb-4">
                <textarea name="content" placeholder="Write your note here..." class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-500 focus:outline-none" rows="5"></textarea>
            </div>
            <div class="flex justify-end">
                <button id="submitNoteBtn" type="submit" class="px-5 py-2 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition">Submit</button>
            </div>
        </form>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const notesContainer = document.getElementById('notesContainer');
    const noteModal = document.getElementById('noteModal');
    const openModalBtn = document.getElementById('openNoteModal');
    const closeModalBtn = document.getElementById('closeNoteModal');
    const addNoteForm = document.getElementById('addNoteForm');

    // Open modal
    openModalBtn.addEventListener('click', () => noteModal.classList.remove('hidden'));

    // Close modal
    closeModalBtn.addEventListener('click', () => noteModal.classList.add('hidden'));
    noteModal.addEventListener('click', (e) => { if(e.target === noteModal) noteModal.classList.add('hidden'); });


    addNoteForm.addEventListener("submit", async (e) => {
        e.preventDefault();
         const submitBtn = document.getElementById("submitNoteBtn");

        // Disable button and show submitting text
        submitBtn.disabled = true;
        submitBtn.innerText = "Submitting...";

        const formData = new FormData(addNoteForm);
        const projectId = addNoteForm.dataset.projectId;
        const currentHost = window.location.host;

        try {
            const response = await fetch(`http://${currentHost}/notes/newNote/${projectId}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                },
                body: formData
            });

            const data = await response.json();

            if (!response.ok) {
                console.error("Note failed:", data);
                toastr.error(data.message || "Failed to add note");
                return;
            }

            toastr.success("Note added successfully!");
            noteModal.classList.add('hidden');

            // Clear textarea
            addNoteForm.reset();

            // Reset button
            submitBtn.disabled = false;
            submitBtn.innerText = "Submit";

            // Refresh notes
            reloadNotes(projectId);

        } catch (error) {
            console.error("Error:", error);
            toastr.error("An error occurred while adding the note.");
        }
    });

    async function reloadNotes(projectId) {
        const currentHost = window.location.host;

        notesContainer.innerHTML = '<p class="text-gray-500">Refreshing notes...</p>';

        try {
            const res = await fetch(`http://${currentHost}/notes/projects/${projectId}/partial`);
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            const html = await res.text();
            notesContainer.innerHTML = html;
        } catch (err) {
            console.error('Failed to reload notes:', err);
            notesContainer.innerHTML = '<p class="text-red-500">Failed to load notes.</p>';
        }
    }
});
</script>
