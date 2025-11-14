<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Client Portal - Tunde Adebayo Consulting</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Toastr -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

  <style>
    body { font-family: 'Inter', sans-serif; }
    .tab-btn.active { background-color:#6e11b0; color:white; }
    .pin-box { width: 45px; height: 55px; }
  </style>

</head>
<body class="bg-gray-50 text-gray-800">

<!-- ======================= ACCESS CODE MODAL ======================= -->
<div id="accessModal"
     class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50">

    <div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-xl">
        <h2 class="text-2xl font-bold text-center mb-6">Enter Access Code</h2>
        <p class="text-gray-600 text-center mb-6">Enter the 6-digit code sent to your email.</p>

        <form id="accessForm" class="space-y-6">
            @csrf

            <div class="flex justify-center gap-3">
                <input maxlength="1" class="pin-input pin-box text-center border rounded-lg text-xl font-bold" />
                <input maxlength="1" class="pin-input pin-box text-center border rounded-lg text-xl font-bold" />
                <input maxlength="1" class="pin-input pin-box text-center border rounded-lg text-xl font-bold" />
                <input maxlength="1" class="pin-input pin-box text-center border rounded-lg text-xl font-bold" />
                <input maxlength="1" class="pin-input pin-box text-center border rounded-lg text-xl font-bold" />
                <input maxlength="1" class="pin-input pin-box text-center border rounded-lg text-xl font-bold" />
            </div>

            <button id="accessSubmitBtn"
                class="w-full bg-purple-600 text-white py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                Continue
            </button>
        </form>
    </div>
</div>
<!-- ======================= END ACCESS CODE MODAL ======================= -->


<!-- ======================= PORTAL CONTENT (hidden initially) ======================= -->
<div id="portalContent" class="hidden">

    <main class="container mx-auto px-6 py-10 md:py-16 max-w-6xl">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

            <!-- Project Title -->
            <div class="text-center mb-10">
                <h1 class="text-3xl font-extrabold text-gray-900">Client Project Portal</h1>
                <p class="text-gray-600 mt-2">
                    Project:
                    <span class="text-purple-600 font-semibold">
                        {{ $project->service->name ?? 'N/A' }}
                    </span>
                </p>
            </div>

            <!-- Tabs -->
            <div class="flex flex-wrap gap-2 border-b pb-2 mb-6">
                <button class="tab-btn px-4 py-2 rounded-lg hover:bg-purple-300 active" data-tab="overview">Overview</button>
                <button class="tab-btn px-4 py-2 rounded-lg hover:bg-purple-300" data-tab="invoices">Financials</button>
                <button class="tab-btn px-4 py-2 rounded-lg hover:bg-purple-300" data-tab="documents">Documents</button>
                <button class="tab-btn px-4 py-2 rounded-lg hover:bg-purple-300" data-tab="notes">Notes</button>
            </div>

            <!-- Content -->
            <div id="tab-content">
                @include('portal.project.partials.overview')
                @include('portal.project.partials.financials')
                @include('portal.project.partials.documents')
                @include('portal.project.partials.notes')
            </div>

        </div>
    </main>
</div>
<!-- ======================= END PORTAL CONTENT ======================= -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
   $(document).ready(function () {
    $("#accessModal").addClass("hidden");
    $("#portalContent").addClass("hidden");

    $.get("/portal/check-access", function (data) {
        if (data.access === true) {
            $("#portalContent").removeClass("hidden");
        } else {
            $("#accessModal").removeClass("hidden");
        }
    });
});


lucide.createIcons();

// TAB SWITCHER
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.add('hidden'));

        btn.classList.add('active');
        document.getElementById(btn.dataset.tab).classList.remove('hidden');
    });
});

// ======================= PIN INPUT LOGIC =======================
const pinInputs = document.querySelectorAll('.pin-input');


pinInputs.forEach((input, index) => {
    input.addEventListener('input', () => {
        if (input.value.length === 1 && index < pinInputs.length - 1) {
            pinInputs[index + 1].focus();
        }
    });

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !input.value && index > 0) {
            pinInputs[index - 1].focus();
        }
    });
});

// ======================= ACCESS CODE SUBMIT =======================
document.getElementById('accessForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const submitBtn = document.getElementById('accessSubmitBtn');
    submitBtn.disabled = true;
    submitBtn.innerText = "Verifying...";

    let code = "";
    pinInputs.forEach(i => code += i.value);

    try {
        const response = await fetch("/portal/verify-access", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Content-Type": "application/json",
            },
            credentials: 'same-origin', // ensures cookies are sent

            body: JSON.stringify({ access_code: code })
        });

        const data = await response.json();

        if (!response.ok) {
            toastr.error(data.message || "Invalid code");
            submitBtn.disabled = false;
            submitBtn.innerText = "Continue";
            return;
        }

        toastr.success("Access granted!");
        document.getElementById('accessModal').classList.add('hidden');
        document.getElementById('portalContent').classList.remove('hidden');

    } catch (error) {
        toastr.error("An error occurred");
    }

    submitBtn.disabled = false;
    submitBtn.innerText = "Continue";
});
</script>

</body>
</html>
