<meta name="csrf-token" content="{{ csrf_token() }}">

<div id="documents" class="tab-pane hidden">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold text-gray-900">Project Documents</h3>
        <!-- Add ID so JS can open modal -->
        <button id="openUploadModal" class="bg-purple-50 text-purple-700 hover:bg-purple-100 font-semibold py-2 px-3 rounded-lg flex items-center text-sm">
            <i data-lucide="upload-cloud" class="w-4 h-4 mr-2"></i> Upload
        </button>
    </div>
    <div class="space-y-3">
        @forelse ($documents as $doc)
            <div class="flex flex-col md:flex-row md:items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100">
                <div class="flex items-center space-x-3">
                    <i data-lucide="file-check-2" class="w-5 h-5 text-green-600"></i>
                    <div>
                        <p class="font-medium text-gray-800">{{ $doc['title'] }}</p>
                        <p class="text-xs text-gray-500">Type: {{ ucfirst($doc['type']) }}</p>
                        <p class="text-xs text-gray-500">Shared: {{ \Carbon\Carbon::parse($doc['created_at'])->format('M d, Y') }}</p>

                        @if(!empty($doc['file']['status']))
                            <p class="text-xs font-semibold mt-1">
                                Status:
                                <span class="@if($doc['file']['status'] == 'Signed') text-green-700
                                            @elseif($doc['file']['status'] == 'Rejected') text-red-700
                                            @elseif($doc['file']['status'] == 'Pending') text-yellow-800
                                            @elseif($doc['file']['status'] == 'Reviewed') text-blue-600
                                            @elseif($doc['file']['status'] == 'Downloaded') text-purple-600
                                            @else text-gray-700 @endif">
                                    {{ ucfirst($doc['file']['status']) }}
                                </span>
                            </p>
                        @endif
                    </div>
                </div>

                <div class="flex items-center space-x-2 mt-2 md:mt-0">
                    @if(!empty($doc['file']['file_path']))
                        <a href="{{ $doc['file']['file_path'] }}" target="_blank" class="text-gray-400 hover:text-gray-600">
                            <i data-lucide="download" class="w-5 h-5"></i>
                        </a>
                    @endif

                    @if(in_array(strtolower($doc['type']), ['nda', 'proposal', 'contract']))
                        <button class="px-2 py-1 bg-purple-50 text-purple-700 rounded-md text-xs hover:bg-purple-100" onclick="openActionModal('{{ $doc['id'] }}','signed')">Upload Signed</button>
                        <button class="px-2 py-1 bg-yellow-50 text-yellow-800 rounded-md text-xs hover:bg-yellow-100" onclick="openActionModal('{{ $doc['id'] }}','review')">Review</button>
                        <button class="px-2 py-1 bg-red-50 text-red-700 rounded-md text-xs hover:bg-red-100" onclick="openActionModal('{{ $doc['id'] }}','reject')">Reject</button>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-500">No documents uploaded yet.</p>
        @endforelse
    </div>


            <!-- Action Modal -->
            <div id="actionModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-white rounded-2xl w-full max-w-lg p-6 relative">
                    <button id="closeActionModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                    <h3 id="actionModalTitle" class="text-lg font-bold mb-4">Action</h3>

                    <form id="actionForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="doc_id" id="modalDocId">
                        <input type="hidden" name="action_type" id="modalActionType">

                        <div class="mb-4" id="fileInputContainer">
                            <label class="block text-gray-700 text-sm mb-1" id="fileLabel">Upload File</label>
                            <input type="file" name="file" id="modalFileInput" class="w-full">
                        </div>

                        <div class="mb-4" id="commentContainer">
                            <label class="block text-gray-700 text-sm mb-1">Comment</label>
                            <textarea name="comment" rows="3" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-purple-500 focus:outline-none"></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-5 py-2 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Script -->
            <script>
                const actionModal = document.getElementById('actionModal');
                const closeActionModalBtn = document.getElementById('closeActionModal');
                const modalTitle = document.getElementById('actionModalTitle');
                const modalDocId = document.getElementById('modalDocId');
                const modalActionType = document.getElementById('modalActionType');
                const fileInputContainer = document.getElementById('fileInputContainer');
                const commentContainer = document.getElementById('commentContainer');
                const fileLabel = document.getElementById('fileLabel');

                function openActionModal(docId, actionType) {
                    modalDocId.value = docId;
                    modalActionType.value = actionType;

                    if(actionType === 'signed') {
                        modalTitle.innerText = 'Upload Signed Document';
                        fileInputContainer.classList.remove('hidden');
                        commentContainer.classList.add('hidden');
                    } else if(actionType === 'review') {
                        modalTitle.innerText = 'Submit Review';
                        fileInputContainer.classList.add('hidden');
                        commentContainer.classList.remove('hidden');
                    } else if(actionType === 'reject') {
                        modalTitle.innerText = 'Reject Document';
                        fileInputContainer.classList.add('hidden');
                        commentContainer.classList.remove('hidden');
                    }

                    actionModal.classList.remove('hidden');
                }

                closeActionModalBtn.addEventListener('click', () => {
                    actionModal.classList.add('hidden');
                });

                // Close modal if clicking outside content
                actionModal.addEventListener('click', (e) => {
                    if(e.target === actionModal) {
                        actionModal.classList.add('hidden');
                    }
                });
            </script>
        </div>

        <!-- Upload Modal -->
        <div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-2xl w-full max-w-lg p-6 relative">
                <button id="closeUploadModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
                <h3 class="text-lg font-bold mb-4">Upload Document</h3>

                <form method="POST" enctype="multipart/form-data" data-project-id="{{ $project->client_project_id }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm mb-1">Document Title</label>
                        <input type="text" name="title" required class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm mb-1">Type</label>
                        <select name="type" required class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                            <option value="">Select Type</option>
                            <option value="Proposal">Proposal</option>
                            <option value="Contract">Contract</option>
                            <option value="NDA">NDA</option>
                            <option value="General">General</option>

                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm mb-1">File</label>
                        <input type="file" name="file" required class="w-full">
                    </div>

                    <div class="flex justify-end">
                        <button id="submitNoteBtn"  type="submit" class="px-5 py-2 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition">Upload</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Script -->
        <script>
            const openModalBtn = document.getElementById('openUploadModal');
            const closeModalBtn = document.getElementById('closeUploadModal');
            const modal = document.getElementById('uploadModal');

            openModalBtn.addEventListener('click', () => {
                modal.classList.remove('hidden');
            });

            closeModalBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
            });

            // Close modal if clicking outside the modal content
            modal.addEventListener('click', (e) => {
                if(e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
            const uploadForm = document.querySelector("#uploadModal form");
            const uploadModal = document.getElementById("uploadModal");
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const documentsContainer = document.querySelector('#documents .space-y-3');

                uploadForm.addEventListener("submit", async (e) => {
                    e.preventDefault();
                    const submitBtn = document.getElementById("submitNoteBtn");

                    // Disable button and show submitting text
                    submitBtn.disabled = true;
                    submitBtn.innerText = "Submitting...";

                    const formData = new FormData(uploadForm);
                    const cprojectId = uploadForm.dataset.projectId; // ✅ use real project ID
                    const currentHost = window.location.host; // e.g. john.localhost
                    const apiUrl = `http://${currentHost}/documents/newDocument/${cprojectId}`;

                    // Laravel expects 'business_docs[]' for files
                    const fileInput = uploadForm.querySelector('input[name="file"]');
                    if (fileInput && fileInput.files.length > 0) {
                        formData.append('business_docs[]', fileInput.files[0]);
                    }

                    try {
                        const response = await fetch(apiUrl, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": csrfToken,
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            console.error("Upload failed:", data);

                            toastr.error(data.message || "Upload failed");

                            return;
                        }

                        toastr.success("Document added successfully!");
                        console.log("Response:", data);

                        // Close the upload modal
                        uploadModal.classList.add("hidden");

                        // Clear the form
                        uploadForm.reset();
                        // Reset button
                        submitBtn.disabled = false;
                        submitBtn.innerText = "Submit";

                        // Refresh documents list
                        if (documentsContainer) { //you can useync just like in notes
                            const reloadUrl = `${window.location.protocol}//${currentHost}/documents/projects/${cprojectId}/partial`;
                            documentsContainer.innerHTML = '<p class="text-gray-500">Refreshing documents...</p>';

                            fetch(reloadUrl)
                                .then(res => {
                                    if (!res.ok) throw new Error(`HTTP ${res.status}`);
                                    return res.text();
                                })
                                .then(html => {
                                    documentsContainer.innerHTML = html;
                                    lucide.createIcons(); // refresh icons
                                })
                                .catch(err => {
                                    console.error('Failed to reload documents:', err);
                                    documentsContainer.innerHTML = '<p class="text-red-500">Failed to load documents.</p>';
                                });
                        }


                    } catch (error) {
                        console.error("Error:", error);
                        toastr.error("An error occurred while uploading the document.");
                    }
                });
            });
        </script>

