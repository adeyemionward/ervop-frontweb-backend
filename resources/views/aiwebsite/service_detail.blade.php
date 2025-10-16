<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Strategy Consultation - Tunde Adebayo</title>
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
        html {
            scroll-behavior: smooth;
        }
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
        }
        .faq-question.active + .faq-answer {
            max-height: 200px; /* Adjust as needed */
        }
        .faq-question.active .icon-plus {
            transform: rotate(45deg);
        }
    </style>
</head>
<body class="bg-white text-gray-800">

    <!-- Header -->
    <header class="sticky top-0 bg-white/90 backdrop-blur-md z-50 border-b border-gray-200">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Tunde Adebayo</h1>
            <nav class="hidden md:flex items-center space-x-8">
                <a href="#" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Home</a>
                <a href="#" class="text-blue-600 hover:text-blue-600 font-semibold transition-colors">Services</a>
                <a href="#" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">About</a>
                <a href="#" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Contact</a>
            </nav>
            <a href="#" class="bg-blue-600 text-white hover:bg-blue-700 font-semibold py-2 px-5 rounded-lg transition-colors hidden md:flex">
                Book a Consultation
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="relative py-20 md:py-32 bg-gray-800">
            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=2940&auto=format&fit=crop" alt="Strategy session" class="absolute inset-0 w-full h-full object-cover opacity-30">
            <div class="relative container mx-auto px-6 text-center text-white">
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight">
                    {{ $serviceDetail['name'] ?? '' }}
                </h1>
                <p class="mt-6 max-w-3xl mx-auto text-lg md:text-xl text-gray-200">
                    {{ $serviceDetail['subheadline'] ?? '' }}
                </p>
            </div>
        </section>

        <!-- Service Details Section -->
        <section class="py-20">
    <div class="container mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        <!-- Left Column: Main Content -->
        <div class="lg:col-span-2">
            <div class="prose prose-lg max-w-none text-gray-600">
                {{-- Service Description --}}
                <h2 class="text-2xl font-bold text-gray-900">{{ $serviceDetail['subheadline'] ?? '' }}</h2>
                <p class="lead mt-4 leading-relaxed">{{ $serviceDetail['description'] ?? '' }}</p>
                
                {{-- What's Included --}}
                <h2 class="mt-12 text-2xl font-bold text-gray-900">What's Included?</h2>
                <ul class="mt-4 space-y-3">
                    @if(!empty($serviceDetail['included']))
                        @foreach ($serviceDetail['included'] as $item)
                            <li class="flex items-start">
                                <i data-lucide="check-circle" class="w-6 h-6 text-green-500 mr-3 mt-1 flex-shrink-0"></i>
                                <span>{{ $item }}</span>
                            </li>
                        @endforeach
                    @endif
                </ul>

                {{-- Who It's For --}}
                <h2 class="mt-12 text-2xl font-bold text-gray-900">Who is this for?</h2>
                <p class="leading-relaxed mt-4">{{ $serviceDetail['who_for'] ?? '' }}</p>
            </div>
        </div>

        <!-- Right Column: Booking Card (Sticky) -->
        <aside class="lg:col-span-1 lg:sticky top-28">
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-lg flex flex-col items-center text-center space-y-4">
                <h3 class="text-xl font-bold text-gray-900">Ready to get started?</h3>
                <p class="text-gray-600">Take the next step and get the help you need today.</p>
                <a href="#"
                class="w-full bg-blue-600 text-white hover:bg-blue-700 font-semibold py-3 px-6 rounded-lg transition-colors">
                    Book Appointment
                </a>
            </div>
        </aside>


    </div>
</section>

        
          <section id="process" class="py-20 bg-gray-50">
            <div class="px-4 md:px-6 lg:px-8 max-w-full mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                        Our Process
                    </h2>
                    <p class="mt-3 text-lg text-gray-600">
                        {{ data_get($processContent, 'process.home.process.section_title') }}
                    </p>
                </div>

                @php
                    $processTitles = data_get($processContent, 'process.home.process.title', []);
                    $processDescriptions = data_get($processContent, 'process.home.process.description', []);
                    $count = count($processTitles);

                    // Dynamically determine grid columns (1 to 4)
                    $gridCols = match (true) {
                        $count === 1 => 'grid-cols-1',
                        $count === 2 => 'md:grid-cols-2',
                        $count === 3 => 'md:grid-cols-3',
                        default => 'md:grid-cols-4', // max 4 columns
                    };
                @endphp

                <div class="grid {{ $gridCols }} gap-8 text-center">
                    @foreach ($processTitles as $index => $title)
                        @php
                            $description = data_get($processDescriptions, $index);
                        @endphp

                        <div>
                            <div class="bg-blue-100 w-20 h-20 rounded-full mx-auto flex items-center justify-center">
                                {{-- Optional: assign icons based on the step number --}}
                                @switch($loop->iteration)
                                    @case(1)
                                        <i data-lucide="search" class="w-10 h-10 text-blue-600"></i>
                                        @break
                                    @case(2)
                                        <i data-lucide="file-text" class="w-10 h-10 text-blue-600"></i>
                                        @break
                                    @case(3)
                                        <i data-lucide="rocket" class="w-10 h-10 text-blue-600"></i>
                                        @break
                                    @case(4)
                                        <i data-lucide="trending-up" class="w-10 h-10 text-blue-600"></i>
                                        @break
                                    @default
                                        <i data-lucide="check-circle" class="w-10 h-10 text-blue-600"></i>
                                @endswitch
                            </div>

                            <h3 class="mt-6 text-xl font-bold">
                                {{ $loop->iteration }}. {{ $title }}
                            </h3>

                            <p class="mt-2 text-gray-600">
                                {{ $description }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto px-6 py-12 text-center">
            <div class="border-t border-gray-700 pt-8 text-sm text-gray-400">
                <p>&copy; 2025 Tunde Adebayo. Powered by Ervop.</p>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();

        // FAQ Accordion Logic
        const faqQuestions = document.querySelectorAll('.faq-question');
        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                question.classList.toggle('active');
            });
        });
    </script>
</body>
</html>
