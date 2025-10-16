<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services - Aisha Bello</title>
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
        /* Dashed line for the process section */
        .process-step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 4rem; /* Adjust based on icon circle size */
            left: 50%;
            transform: translateX(-50%);
            height: calc(100% - 4rem);
            border-left: 2px dashed #cbd5e1; /* border-gray-300 */
        }
        @media (min-width: 768px) {
            .process-step:not(:last-child)::after {
                top: 2.5rem;
                left: calc(50% + 2.5rem);
                width: calc(100% - 5rem);
                height: 2px;
                border-left: none;
                border-top: 2px dashed #cbd5e1;
            }
        }
    </style>
</head>
<body class="bg-white text-gray-800">

    <!-- Header -->
    <header class="sticky top-0 bg-white/90 backdrop-blur-md z-50 border-b border-gray-200">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Aisha Bello</h1>
            <nav class="hidden md:flex items-center space-x-8">
                <a href="#" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Home</a>
                <a href="#" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Shop</a>
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
                <h1 class="text-4xl md:text-5xl font-extrabold leading-tight">
                    Our Services
                </h1>
                <p class="mt-6 max-w-3xl mx-auto text-lg md:text-xl text-gray-200">
                     {{ data_get($serviceContent, 'services_hero.services.services_hero.subheadline', 'Expert guidance to bring your vision to life.') }}
                </p>
            </div>
        </section>

        <!-- Services Grid Section -->
        <section id="services" class="pb-10 mt-10 bg-gray-50">
            <div class="px-4 md:px-6 lg:px-8 max-w-full mx-auto">
               

                <!-- Services Grid -->
                @php
                    $serviceNames = data_get($serviceContent, 'service_details.services.service_details.service_name', []);
                    $serviceDescriptions = data_get($serviceContent, 'service_details.services.service_details.service_description', []);
                    $count = count($serviceNames);

                    // Dynamically determine grid columns (1 to 4)
                    $gridCols = match (true) {
                        $count === 1 => 'grid-cols-1',
                        $count === 2 => 'md:grid-cols-2',
                        $count === 3 => 'md:grid-cols-3',
                        default => 'md:grid-cols-4',
                        };
                @endphp

                <div class="grid {{ $gridCols }} gap-8">
                    @foreach ($serviceNames as $index => $name)
                        <div class="bg-white p-10 rounded-3xl border border-gray-200 shadow hover:shadow-lg transition duration-300">
                            <div class="w-14 h-14 flex items-center justify-center bg-blue-100 rounded-full">
                                @if ($loop->iteration === 1)
                                    <i data-lucide="code" class="w-7 h-7 text-blue-600"></i>
                                @elseif ($loop->iteration === 2)
                                    <i data-lucide="smartphone" class="w-7 h-7 text-blue-600"></i>
                                @else
                                    <i data-lucide="cloud" class="w-7 h-7 text-blue-600"></i>
                                @endif
                            </div>

                            <h3 class="mt-6 text-2xl font-bold text-gray-900">{{ $name }}</h3>
                          
                            <p class="mt-4 text-gray-600 text-base">
                                {{ Str::words(data_get($serviceDescriptions, $index, ''), 20, '...') }}
                            </p>
                            <a href="{{ route('serviceDetails', [
                            
                                    'username' => $client_user->ervop_url,
                                    
                                    'serviceName' => str_replace(' ', '-', $name)
                                ]) }}"
                                class="mt-6 inline-flex items-center text-blue-600 font-semibold hover:text-blue-800 transition">
                                Learn More
                                <i data-lucide="external-link" class="ml-2 w-4 h-4"></i>
                            </a>


                        </div>
                    @endforeach
                </div>

            </div>
        </section>

        <!-- Our Process Section -->
         <!-- NEW: How It Works Section -->
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
    <footer id="contact" class="bg-gray-800 text-white">
        <div class="container mx-auto px-6 py-12 text-center">
            <h2 class="text-3xl font-bold">Ready to Get Started?</h2>
            <p class="mt-4 max-w-xl mx-auto text-gray-300">Let's create something beautiful together.</p>
            <div class="mt-8">
                <a href="#" class="bg-blue-600 text-white hover:bg-blue-700 font-semibold py-3 px-8 rounded-lg text-lg transition-colors shadow-lg hover:shadow-xl">
                    Book Your Free Consultation
                </a>
            </div>
            <div class="mt-12 border-t border-gray-700 pt-8 text-sm text-gray-400">
                <p>&copy; 2025 Aisha Bello. Powered by Ervop.</p>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
