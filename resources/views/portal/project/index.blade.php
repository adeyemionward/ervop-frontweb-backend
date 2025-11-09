<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Client Portal - Tunde Adebayo Consulting</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .tab-btn.active {
      background-color:#6e11b0; /* purple-600 */
      color: white;
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <main class="container mx-auto px-6 py-10 md:py-16 max-w-6xl">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <!-- Project Title -->
            <div class="text-center mb-10">
                <h1 class="text-3xl font-extrabold text-gray-900">Client Project Portal</h1>
                <p class="text-gray-600 mt-2">Project: <span class="text-purple-600 font-semibold">{{ $project->service->name ?? 'N/A' }}</span></p>
            </div>

            <!-- Tabs -->
            <div class="flex flex-wrap gap-2 border-b border-gray-200 pb-2 mb-6">
                <button class="tab-btn px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-purple-300 active" data-tab="overview">Overview</button>
                <button class="tab-btn px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-purple-300" data-tab="invoices">Financials</button>
                <button class="tab-btn px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-purple-300" data-tab="documents">Documents</button>
                <button class="tab-btn px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-purple-300" data-tab="notes">Notes</button>
            </div>

            <!-- Tab Content -->
            <div id="tab-content">
                <!-- Overview Tab -->
                @include('portal.project.partials.overview')

                <!-- Invoices Tab -->
                @include('portal.project.partials.financials')

                <!-- Documents Tab -->
                @include('portal.project.partials.documents')

                <!-- Notes Tab -->
                @include('portal.project.partials.notes')
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();

        const tabs = document.querySelectorAll('.tab-btn');
        const panes = document.querySelectorAll('.tab-pane');

        tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            panes.forEach(p => p.classList.add('hidden'));
            tab.classList.add('active');
            document.getElementById(tab.dataset.tab).classList.remove('hidden');
        });
        });
    </script>
</body>
</html>
