@php
    use Illuminate\Support\Str;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adeyemi's Designs - Handcrafted Fashion</title>
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
        /* Styles for sliders */
        .slider-container {
            overflow: hidden;
        }
        .slider-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        .slide {
            min-width: 100%;
            box-sizing: border-box;
        }
        .group:hover .add-to-cart {
            transform: translateY(0);
            opacity: 1;
        }
        /* Styles for the new hero carousel */
        .hero-slider-track {
            display: flex;
            transition: transform 0.7s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .hero-slide {
            min-width: 100%;
            box-sizing: border-box;
            position: relative;
        }
        .hero-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .pagination-dot.active {
            background-color: white;
            transform: scale(1.2);
        }
    </style>
</head>
<body class="bg-white text-gray-800">

    <!-- Header is now positioned absolutely over the hero section -->
    <header class="sticky top-0 bg-white/70 backdrop-blur-md z-50 border-b border-gray-200">
        <div class="bg-white/50 shadow-lg border border-gray-200/80">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-900">Our Logo</h1>
                <nav class="hidden lg:flex items-center space-x-8">
                   <a href="{{ route('home', ['username' => $client_user->ervop_url]) }}" class="text-gray-600 hover:text-orange-500 font-medium transition-colors">Home</a>
                    <a href="{{ route('about', ['username' => $client_user->ervop_url]) }}" class="text-gray-600 hover:text-orange-500 font-medium transition-colors">About</a>
                    <a href="{{ route('services', ['username' => $client_user->ervop_url]) }}" class="text-gray-600 hover:text-orange-500 font-medium transition-colors">Services</a>

                    <a href="portfolio.html" class="text-gray-600 hover:text-orange-500 font-medium transition-colors">Portfolio</a>
                    <a href="{{ route('faqs', ['username' => $client_user->ervop_url]) }}" class="text-gray-600 hover:text-orange-500 font-medium transition-colors">Faq</a>
                    <a href="{{ route('contact', ['username' => session('client_username')]) }}" class="text-gray-600 hover:text-orange-500 font-medium transition-colors">Contact</a>
                </nav>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('scheduleAppointment', ['username' => session('client_username')]) }}" class="bg-purple-600 text-white hover:bg-blue-700 font-semibold py-2 px-5 rounded-lg transition-colors hidden md:flex">
                        Book Appointment
                    </a>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-button" class="lg:hidden text-gray-500 hover:text-orange-500">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu Panel -->
        <div id="mobile-menu" class="hidden lg:hidden mt-2 rounded-2xl bg-white/95 backdrop-blur-md shadow-lg border border-gray-200/80">
            <nav class="flex flex-col p-4 space-y-2">
                <a href="{{ route('home', ['username' => session('client_username')]) }}" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md">Home</a>
                <a href="{{ route('about', ['username' => session('client_username')]) }}" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md">About</a>
                <a href="{{ route('services', ['username' => session('client_username')]) }}" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md">Services</a>

                <a href="portfolio.html" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md">Portfolio</a>
                <a href="{{ route('faqs', ['username' => $client_user->ervop_url]) }}" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md">Faq</a>
                <a href="{{ route('contact', ['username' => session('client_username')]) }}" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md">Contact</a>

                <a href="{{ route('scheduleAppointment', ['username' => session('client_username')]) }}" class="bg-blue-600 text-white hover:bg-blue-700 font-semibold py-2 px-5 rounded-lg transition-colors md:flex">
                    Book Appointment
                </a>
            </nav>

        </div>
    </header>

    <!-- Main Content -->
     <main>
        <!-- Hero Section with Image Carousel -->
         <section id="home" class="relative h-[90vh] md:h-[100vh] w-full slider-container">
            <div class="hero-slider-track h-full">
                <!-- Slide 1 -->
                <div class="hero-slide h-full">
                    <img src="https://images.unsplash.com/photo-1709884735626-63e92727d8b6?q=80&w=1228&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Fashion model 1">
                </div>
                <!-- Slide 2 -->
                <div class="hero-slide h-full">
                    <img src="https://plus.unsplash.com/premium_photo-1683140721927-aaed410fae29?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Fashion model 2">
                </div>
                <!-- Slide 3 -->
                <div class="hero-slide h-full">
                    <img src="https://images.unsplash.com/photo-1645120578522-16c6debcc1c0?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Fashion model 3">
                </div>
                <!-- Slide 4 -->
                <div class="hero-slide h-full">
                    <img src="https://plus.unsplash.com/premium_photo-1683140721927-aaed410fae29?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Fashion model 4">
                </div>
            </div>

            <!-- Hero Content Overlay -->
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="absolute inset-0 container mx-auto px-6 flex flex-col justify-center items-center text-white">
                 <div class="w-full max-w-3xl text-center">
                    <span class="text-orange-400 font-semibold">{{ data_get($homeContent, 'hero.home.hero.tagline') }}</span>
                    <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mt-4">{{ data_get($homeContent, 'hero.home.hero.headline') }}</h1>
                    <p class="mt-6 max-w-lg mx-auto text-lg text-gray-200">{{ data_get($homeContent, 'hero.home.hero.subheadline') }}</p>


                    <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                        <a href="#products" class="bg-white text-purple-700 font-semibold px-6 py-3 rounded-full hover:bg-purple-100 transition">Explore Services</a>
                        <a href="#services" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-3 rounded-full transition">Book Appointment</a>
                    </div>
                </div>
            </div>

            <!-- Carousel Navigation -->
            <div class="absolute bottom-8 right-8 flex items-center space-x-4">
                <button id="heroPrevBtn" class="bg-white/20 text-white p-3 rounded-full hover:bg-white/40 transition-colors backdrop-blur-sm">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </button>
                <button id="heroNextBtn" class="bg-white/20 text-white p-3 rounded-full hover:bg-white/40 transition-colors backdrop-blur-sm">
                    <i data-lucide="chevron-right" class="w-6 h-6"></i>
                </button>
            </div>

            <!-- Carousel Pagination Dots -->
            <div id="heroPagination" class="absolute bottom-8 left-1/2 -translate-x-1/2 flex space-x-2">
                <!-- Dots will be generated by JS -->
            </div>
        </section>

        <!-- Main About Block -->
        <section id="categories" class="py-20 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="bg-white p-8 md:p-12 rounded-2xl grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Column: Categories List -->
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-semibold text-purple-600 bg-purple-100 px-3 py-1 rounded-full">ABOUT US</span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-4">
                            {{ data_get($aboutContent, 'our_story.about.our_story.headline') }}
                        </h2>
                        <p class="mt-3 text-lg text-gray-600">
                            {{ data_get($aboutContent, 'our_story.about.our_story.about_us') }}
                        </p>
                        <div class="mt-8 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8 items-center">
                                <div class="md:col-span-3 ">
                                    <div class="flex space-x-8">
                                        <div>
                                            <p class="text-4xl font-bold text-blue-600">{{ data_get($aboutContent, 'our_story.about.our_story.yoe') }}+</p>
                                            <p class="text-gray-500 mt-1">Years of Experience</p>
                                        </div>
                                        <div>
                                            <p class="text-4xl font-bold text-blue-600">{{ data_get($aboutContent, 'our_story.about.our_story.customers_served') }}+</p>
                                            <p class="text-gray-500 mt-1">Businesses Empowered</p>
                                        </div>

                                    </div>
                                    <!-- NEW: CTA Button Added Here -->
                                    <div class="mt-8">
                                        <a href="#" class="bg-blue-600 text-white hover:bg-blue-700 font-semibold py-3 px-6 rounded-lg transition-colors shadow-sm">
                                            Explore More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right Column: Image -->
                    <div class="w-full h-80 md:h-full rounded-2xl overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1521737852567-6949f3f9f2b5?q=80&w=1147&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Category showcase" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </section>


        <!-- Services Section -->
        <section id="services" class="pb-20 bg-gray-50">
            <div class="px-4 md:px-6 lg:px-8 max-w-full mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                        Our Services
                        {{-- {{ data_get($serviceContent, 'services_hero.services.services_hero.headline', 'Our Services') }} --}}
                    </h2>
                    <p class="mt-3 text-lg text-gray-600">
                        {{ data_get($serviceContent, 'services_hero.services.services_hero.subheadline', 'Expert guidance to bring your vision to life.') }}
                    </p>
                </div>

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


         <!-- Why Choose Us Section -->
        <section class="w-full">
            <div class="container mx-auto pt-10">
                <div class="text-center mb-16 px-6 pt-4">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                        Why Choose Us
                    </h2>
                    <p class="mt-3 text-lg text-gray-600">{{ data_get($homeContent, 'why_choose_us.home.why_choose_us.section_title') }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach (data_get($homeContent, 'why_choose_us.home.why_choose_us.title', []) as $index => $title)
                        @php
                            $description = data_get($homeContent, "why_choose_us.home.why_choose_us.description.$index");
                        @endphp

                        {{-- Use blue card for the 3rd item --}}
                        @if ($loop->iteration === 3)
                            <div class="bg-blue-600 text-white p-8 rounded-2xl shadow-lg md:row-span-2 flex flex-col">
                                <div class="bg-white/20 text-white w-12 h-12 rounded-lg flex items-center justify-center">
                                    <i data-lucide="rocket" class="w-6 h-6"></i>
                                </div>
                                <h3 class="text-2xl font-bold mt-5">{{ $title }}</h3>
                                <p class="mt-2 text-blue-100 flex-grow">
                                    {{ $description }}
                                </p>
                                <a href="/book-appointment">
                                <button class="mt-6 bg-white text-blue-700 font-semibold py-3 px-6 rounded-lg w-full flex items-center justify-center hover:bg-blue-50 transition-colors">
                                    <span>Book Appointment</span>
                                    <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                                </button>
                                </a>
                            </div>
                        @else
                            {{-- Normal white card for others --}}
                            <div class="p-6 bg-white rounded-2xl shadow-md">
                                <h3 class="text-xl font-semibold text-gray-800">{{ $title }}</h3>
                                <p class="mt-2 text-gray-600">{{ $description }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>

         <!-- NEW: How It Works Section -->
        <section id="process" class="py-20 bg-gray-50">
            <div class="px-4 md:px-6 lg:px-8 max-w-full mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                        Our Process
                    </h2>
                    <p class="mt-3 text-lg text-gray-600">
                        {{ data_get($homeContent, 'process.home.process.section_title') }}
                    </p>
                </div>

                @php
                    $processTitles = data_get($homeContent, 'process.home.process.title', []);
                    $processDescriptions = data_get($homeContent, 'process.home.process.description', []);
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


        <!-- Booking Section -->
        <section id="booking" class="py-20">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold text-gray-900">Let's Create Something Beautiful Together</h2>
                <p class="mt-4 max-w-xl mx-auto text-lg text-gray-600">A 30-minute discovery call is the first step to understanding your needs and exploring how I can help. It's completely free.</p>
                <div class="mt-10">
                    <a href="#" class="bg-blue-600 text-white hover:bg-blue-700 font-semibold py-3 px-8 rounded-lg text-lg transition-colors shadow-lg hover:shadow-xl">
                        Book Your Free Call Now
                    </a>
                </div>
            </div>
        </section>


        <!-- Testimonials Section -->
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-6">
                <h2 class="text-center text-3xl font-bold text-gray-900">What Our Customers Say</h2>
                <div class="relative max-w-3xl mx-auto mt-12 slider-container">
                    <div class="slider-track">
                        <!-- Slides -->
                    @php
                        $reviews = data_get($reviewContent, 'customer_reviews.reviews.customer_reviews', []);
                        $names = data_get($reviews, 'customer_name', []);
                        $comments = data_get($reviews, 'comment', []);
                        $ratings = data_get($reviews, 'star_rating', []);
                    @endphp

                    @foreach($names as $index => $name)
                        <div class="slide p-4 text-center">
                            <p class="text-xl text-gray-700 italic">
                                "{{ data_get($comments, $index, '') }}"
                            </p>
                            <p class="mt-3 text-yellow-500">
                                @php
                                    $stars = (int) filter_var(data_get($ratings, $index, '5'), FILTER_SANITIZE_NUMBER_INT);
                                @endphp
                                {!! str_repeat('★', $stars) !!}{!! str_repeat('☆', 5 - $stars) !!}
                            </p>
                            <p class="mt-6 font-bold text-lg">
                                - {{ $name }}
                            </p>
                        </div>
                    @endforeach

                    </div>
                    <button id="prevBtn" class="absolute top-1/2 left-0 md:-left-12 transform -translate-y-1/2 bg-white p-2 rounded-full shadow-md hover:bg-gray-100"><i data-lucide="chevron-left" class="w-6 h-6 text-gray-600"></i></button>
                    <button id="nextBtn" class="absolute top-1/2 right-0 md:-right-12 transform -translate-y-1/2 bg-white p-2 rounded-full shadow-md hover:bg-gray-100"><i data-lucide="chevron-right" class="w-6 h-6 text-gray-600"></i></button>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-900 text-white">
        <div class="container mx-auto px-6 py-12 text-center">
            <h2 class="text-3xl font-bold">Get in Touch</h2>
            <p class="mt-4 max-w-xl mx-auto text-gray-300">Have a question or a custom request? We'd love to hear from you. Follow us on social media or send us a message.</p>
            <div class="mt-8 flex justify-center space-x-6">
                <a href="#" class="text-gray-400 hover:text-white"><i data-lucide="instagram" class="w-7 h-7"></i></a>
                <a href="#" class="text-gray-400 hover:text-white"><i data-lucide="facebook" class="w-7 h-7"></i></a>
                <a href="#" class="text-gray-400 hover:text-white"><i data-lucide="twitter" class="w-7 h-7"></i></a>
            </div>
            <div class="mt-12 border-t border-gray-700 pt-8 text-sm text-gray-400">
                <p>&copy; 2025 Adeyemi's Designs. Powered by Ervop.</p>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();

        // Mobile Menu Logic
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Hero Carousel Logic
        const heroTrack = document.querySelector('.hero-slider-track');
        if (heroTrack) {
            const heroSlides = Array.from(heroTrack.children);
            const heroNextButton = document.getElementById('heroNextBtn');
            const heroPrevButton = document.getElementById('heroPrevBtn');
            const heroPagination = document.getElementById('heroPagination');

            if(heroSlides.length > 0) {
                const slideWidth = heroSlides[0].getBoundingClientRect().width;
                let currentIndex = 0;

                // Create pagination dots
                heroSlides.forEach((slide, index) => {
                    const dot = document.createElement('button');
                    dot.classList.add('pagination-dot', 'w-3', 'h-3', 'bg-white/50', 'rounded-full', 'transition-all', 'duration-300');
                    if (index === 0) dot.classList.add('active');
                    dot.addEventListener('click', () => moveToHeroSlide(index));
                    heroPagination.appendChild(dot);
                });
                const dots = Array.from(heroPagination.children);

                const updateDots = (targetIndex) => {
                    dots.forEach((dot, index) => {
                        dot.classList.toggle('active', index === targetIndex);
                    });
                };

                const moveToHeroSlide = (targetIndex) => {
                    heroTrack.style.transform = 'translateX(-' + slideWidth * targetIndex + 'px)';
                    currentIndex = targetIndex;
                    updateDots(currentIndex);
                }

                heroNextButton.addEventListener('click', () => {
                    const nextIndex = (currentIndex + 1) % heroSlides.length;
                    moveToHeroSlide(nextIndex);
                });

                heroPrevButton.addEventListener('click', () => {
                    let prevIndex = currentIndex - 1;
                    if (prevIndex < 0) prevIndex = heroSlides.length - 1;
                    moveToHeroSlide(prevIndex);
                });

                setInterval(() => {
                    const nextIndex = (currentIndex + 1) % heroSlides.length;
                    moveToHeroSlide(nextIndex);
                }, 7000); // Auto-slide every 7 seconds
            }
        }


        // Testimonial Slider Logic
        const track = document.querySelector('.slider-track');
        if (track) {
            const slides = Array.from(track.children);
            const nextButton = document.getElementById('nextBtn');
            const prevButton = document.getElementById('prevBtn');

            if(slides.length > 0) {
                const slideWidth = slides[0].getBoundingClientRect().width;
                let currentIndex = 0;

                const moveToSlide = (targetIndex) => {
                    if(track) {
                       track.style.transform = 'translateX(-' + slideWidth * targetIndex + 'px)';
                    }
                    currentIndex = targetIndex;
                }

                nextButton.addEventListener('click', e => {
                    const nextIndex = (currentIndex + 1) % slides.length;
                    moveToSlide(nextIndex);
                });

                prevButton.addEventListener('click', e => {
                    let prevIndex = currentIndex - 1;
                    if (prevIndex < 0) {
                        prevIndex = slides.length - 1;
                    }
                    moveToSlide(prevIndex);
                });

                setInterval(() => {
                    const nextIndex = (currentIndex + 1) % slides.length;
                    moveToSlide(nextIndex);
                }, 5000);
            }
        }
    </script>
</body>
</html>
