<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Project Status - Tunde Adebayo Consulting</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom Icons for a more polished look -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Styles for the timeline connector */
        .timeline-step:not(:last-child) .timeline-content::after {
            content: '';
            position: absolute;
            left: 1.25rem; /* Center of the icon circle */
            top: 3rem; /* Start below the icon circle */
            bottom: -0.5rem; /* End above the next icon circle */
            width: 2px;
            background-color: #e5e7eb; /* border-gray-200 */
            z-index: -1;
        }
        .timeline-step.completed .timeline-icon {
            background-color: #2563eb; /* bg-blue-600 */
            color: white;
        }
        .timeline-step.completed .timeline-content::after {
            background-color: #2563eb; /* bg-blue-600 */
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Tunde Adebayo Consulting</h1>
            <a href="#" class="text-sm font-semibold text-blue-600 hover:underline">Back to Website</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-12 md:py-20">
        <div class="max-w-6xl mx-auto">
            
            <!-- Project Header -->
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900">Your Project is In Progress</h1>
                <p class="mt-3 text-lg text-gray-600">Project: <span class="font-semibold text-blue-600">New Website Design</span></p>
            </div>

            <!-- Main Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <!-- Left Column: Project Status Timeline -->
                <div class="lg:col-span-2">
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Project Progress</h2>
                        <ol class="relative space-y-8">
                            <!-- Step 1: Briefing (Completed) -->
                            <li class="timeline-step completed">
                                <div class="flex items-start">
                                    <div class="timeline-icon flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center">
                                        <i data-lucide="clipboard-list" class="w-6 h-6"></i>
                                    </div>
                                    <div class="timeline-content ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Project Briefing</h3>
                                        <p class="text-sm text-gray-500">July 15, 2025</p>
                                    </div>
                                </div>
                            </li>
                            <!-- Step 2: Strategy (Completed) -->
                            <li class="timeline-step completed">
                                <div class="flex items-start">
                                    <div class="timeline-icon flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center">
                                        <i data-lucide="file-text" class="w-6 h-6"></i>
                                    </div>
                                    <div class="timeline-content ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Strategy & Proposal</h3>
                                        <p class="text-sm text-gray-500">July 20, 2025</p>
                                    </div>
                                </div>
                            </li>
                            <!-- Step 3: Execution (Current Step) -->
                            <li class="timeline-step completed">
                                <div class="flex items-start">
                                    <div class="timeline-icon flex-shrink-0 w-10 h-10 rounded-full ring-8 ring-gray-50 flex items-center justify-center">
                                        <i data-lucide="settings" class="w-6 h-6"></i>
                                    </div>
                                    <div class="timeline-content ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Execution</h3>
                                        <p class="text-sm text-gray-500">Currently in progress</p>
                                    </div>
                                </div>
                            </li>
                            <!-- Step 4: Review (Future Step) -->
                            <li class="timeline-step">
                                <div class="flex items-start">
                                    <div class="timeline-icon flex-shrink-0 w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i data-lucide="eye" class="w-6 h-6 text-gray-500"></i>
                                    </div>
                                    <div class="timeline-content ml-4">
                                        <h3 class="text-lg font-semibold text-gray-400">Final Review</h3>
                                        <p class="text-sm text-gray-400">Estimated: August 25, 2025</p>
                                    </div>
                                </div>
                            </li>
                             <!-- Step 5: Completed (Future Step) -->
                            <li class="timeline-step">
                                <div class="flex items-start">
                                    <div class="timeline-icon flex-shrink-0 w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i data-lucide="party-popper" class="w-6 h-6 text-gray-500"></i>
                                    </div>
                                    <div class="timeline-content ml-4">
                                        <h3 class="text-lg font-semibold text-gray-400">Project Completed</h3>
                                        <p class="text-sm text-gray-400">Estimated: August 30, 2025</p>
                                    </div>
                                </div>
                            </li>
                        </ol>
                         <div class="mt-16 pt-8 border-t border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Project Summary</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left: Deliverables & Financials -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Deliverables</h3>
                        <ul class="space-y-4">
                            <li class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="check-circle-2" class="w-7 h-7 text-green-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">Brand Strategy Document</p>
                                    <p class="text-sm text-gray-500">Status: Completed</p>
                                </div>
                            </li>
                             <li class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="clock" class="w-7 h-7 text-yellow-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">Website Wireframes</p>
                                    <p class="text-sm text-gray-500">Status: In Progress</p>
                                </div>
                            </li>
                        </ul>
                        <div class="mt-6 pt-6 border-t border-gray-200 space-y-2 text-sm">
                            <div class="flex justify-between"><p class="text-gray-600">Project Budget</p><p class="font-medium">₦750,000</p></div>
                            <div class="flex justify-between"><p class="text-gray-600">Amount Paid</p><p class="font-medium">₦250,000</p></div>
                            <div class="flex justify-between text-base"><p class="font-semibold">Balance Remaining</p><p class="font-bold">₦500,000</p></div>
                        </div>
                    </div>
                  
                </div>
            </div>
                    </div>
                     <!-- Project Details -->
                     </div>

                <!-- Right Column: Client Info & Documents -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Client Information</h3>
                        <div class="space-y-4 text-sm">
                            <div>
                                <p class="text-gray-500">Client Name</p>
                                <p class="font-medium text-gray-800">Chioma Nwosu</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Contact Email</p>
                                <p class="font-medium text-gray-800">chioma.n@example.com</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Invoice History Section -->
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Invoice History</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <div>
                                    <p class="font-medium text-gray-800">INV-056</p>
                                    <p class="text-xs text-gray-500">₦250,000</p>
                                </div>
                                <span class="text-xs font-semibold text-green-700 bg-green-100 px-2 py-1 rounded-full">Paid</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <div>
                                    <p class="font-medium text-gray-800">INV-059</p>
                                    <p class="text-xs text-gray-500">₦250,000</p>
                                </div>
                                <span class="text-xs font-semibold text-yellow-800 bg-yellow-200 px-2 py-1 rounded-full">Pending</span>
                            </div>
                        </div>
                    </div>

                    <!-- Secure Documents Section -->
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Project Documents</h3>
                            <button class="bg-blue-50 text-blue-700 hover:bg-blue-100 font-semibold py-2 px-3 rounded-lg flex items-center transition-colors text-sm">
                                <i data-lucide="upload-cloud" class="w-4 h-4 mr-2"></i>
                                <span>Upload File</span>
                            </button>
                        </div>
                        <div class="space-y-3">
                            <a href="#" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100">
                                <div class="flex items-center">
                                    <i data-lucide="file-check-2" class="w-5 h-5 text-green-600 mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-800">Service_Agreement_Signed.pdf</p>
                                        <p class="text-xs text-gray-500">Shared: July 20, 2025</p>
                                    </div>
                                </div>
                                <i data-lucide="download" class="w-5 h-5 text-gray-400"></i>
                            </a>
                            <a href="#" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100">
                                <div class="flex items-center">
                                    <i data-lucide="file-text" class="w-5 h-5 text-gray-500 mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-800">Project_Proposal_v2.pdf</p>
                                        <p class="text-xs text-gray-500">Shared: July 18, 2025</p>
                                    </div>
                                </div>
                                <i data-lucide="download" class="w-5 h-5 text-gray-400"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
