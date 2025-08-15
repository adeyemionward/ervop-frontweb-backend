<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tunde Adebayo | Business Strategy Consultant</title>
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
    </style>
</head>
<body class="bg-white text-gray-800">

    <!-- Header -->
    <header class="sticky top-0 bg-white/90 backdrop-blur-md z-50 border-b border-gray-200">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Tunde Adebayo</h1>
            <nav class="hidden md:flex items-center space-x-8">
                <a href="#services" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Services</a>
                <a href="#process" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Process</a>
                <a href="#about" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">About</a>
                <a href="#contact" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Contact</a>
            </nav>
            <a href="#booking" class="bg-blue-600 text-white hover:bg-blue-700 font-semibold py-2 px-5 rounded-lg transition-colors hidden md:flex">
                Book a Consultation
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="py-20 md:py-32 bg-gray-50">
            <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 leading-tight">
                        Strategic Growth for Nigerian SMEs
                    </h1>
                    <p class="mt-6 max-w-xl text-lg md:text-xl text-gray-600">
                        I help ambitious businesses navigate the complexities of the Nigerian market, optimize their operations, and unlock sustainable growth.
                    </p>
                    <div class="mt-10">
                        <a href="#booking" class="bg-blue-600 text-white hover:bg-blue-700 font-semibold py-3 px-8 rounded-lg text-lg transition-colors shadow-lg hover:shadow-xl">
                            Schedule a Free Discovery Call
                        </a>
                    </div>
                </div>
                 <div>
                    <img src="https://placehold.co/500x500/E2E8F0/4A5568?text=Consultant" alt="Tunde Adebayo" class="rounded-full shadow-2xl w-full max-w-md mx-auto">
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="py-20">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">How I Can Help</h2>
                    <p class="mt-3 text-lg text-gray-600">My services are designed to address the core challenges your business faces.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                    <!-- Service Card 1 -->
                    <div class="bg-gray-50 p-8 rounded-xl border border-gray-200">
                        <i data-lucide="compass" class="w-10 h-10 text-blue-600"></i>
                        <h3 class="mt-5 text-xl font-bold text-gray-900">Business Strategy</h3>
                        <p class="mt-3 text-gray-600">Developing a clear roadmap for market entry, product positioning, and long-term growth.</p>
                    </div>
                    <!-- Service Card 2 -->
                    <div class="bg-gray-50 p-8 rounded-xl border border-gray-200">
                        <i data-lucide="trending-up" class="w-10 h-10 text-blue-600"></i>
                        <h3 class="mt-5 text-xl font-bold text-gray-900">Sales & Marketing</h3>
                        <p class="mt-3 text-gray-600">Creating effective sales funnels and digital marketing strategies to attract and retain customers.</p>
                    </div>
                    <!-- Service Card 3 -->
                    <div class="bg-gray-50 p-8 rounded-xl border border-gray-200">
                        <i data-lucide="settings" class="w-10 h-10 text-blue-600"></i>
                        <h3 class="mt-5 text-xl font-bold text-gray-900">Operational Efficiency</h3>
                        <p class="mt-3 text-gray-600">Streamlining your processes and leveraging technology to reduce costs and improve productivity.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- NEW: How It Works Section -->
        <section id="process" class="py-20 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Our Simple Process</h2>
                    <p class="mt-3 text-lg text-gray-600">A clear and collaborative journey to achieve your business goals.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 max-w-5xl mx-auto text-center">
                    <!-- Step 1 -->
                    <div>
                        <div class="bg-blue-100 w-20 h-20 rounded-full mx-auto flex items-center justify-center">
                            <i data-lucide="calendar-check" class="w-10 h-10 text-blue-600"></i>
                        </div>
                        <h3 class="mt-6 text-xl font-bold">1. Book a Discovery Call</h3>
                        <p class="mt-2 text-gray-600">Schedule a free, no-obligation call to discuss your challenges and goals.</p>
                    </div>
                    <!-- Step 2 -->
                    <div>
                        <div class="bg-blue-100 w-20 h-20 rounded-full mx-auto flex items-center justify-center">
                            <i data-lucide="file-text" class="w-10 h-10 text-blue-600"></i>
                        </div>
                        <h3 class="mt-6 text-xl font-bold">2. Receive a Custom Proposal</h3>
                        <p class="mt-2 text-gray-600">I'll deliver a tailored strategy and a clear proposal outlining the scope and deliverables.</p>
                    </div>
                    <!-- Step 3 -->
                    <div>
                        <div class="bg-blue-100 w-20 h-20 rounded-full mx-auto flex items-center justify-center">
                            <i data-lucide="rocket" class="w-10 h-10 text-blue-600"></i>
                        </div>
                        <h3 class="mt-6 text-xl font-bold">3. Execute & Achieve Results</h3>
                        <p class="mt-2 text-gray-600">We'll work together to implement the strategy and track progress towards your success.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-20">
            <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="order-2 md:order-1">
                    <h2 class="text-3xl font-bold text-gray-900">15+ Years of Experience in the Nigerian Market</h2>
                    <p class="mt-4 text-lg text-gray-600">I'm Tunde Adebayo, a business consultant with a passion for helping Nigerian entrepreneurs succeed. After a decade in corporate strategy, I founded my practice to provide the hands-on, practical advice that I know small businesses need to thrive. My approach is data-driven, direct, and always focused on your bottom line.</p>
                    <div class="mt-6 flex items-center gap-2">
                        <div class="bg-green-100 p-2 rounded-full"><i data-lucide="check" class="w-5 h-5 text-green-600"></i></div>
                        <p class="font-medium">Certified Business Strategist</p>
                    </div>
                     <div class="mt-3 flex items-center gap-2">
                        <div class="bg-green-100 p-2 rounded-full"><i data-lucide="check" class="w-5 h-5 text-green-600"></i></div>
                        <p class="font-medium">Helped over 50 SMEs achieve profitability</p>
                    </div>
                </div>
                <div class="order-1 md:order-2">
                    <img src="https://placehold.co/600x700/4A5568/FFFFFF?text=Tunde+Adebayo" alt="Tunde Adebayo" class="rounded-xl shadow-xl w-full">
                </div>
            </div>
        </section>
        
        <!-- Booking Section -->
        <section id="booking" class="py-20 bg-gray-50">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold text-gray-900">Ready to Grow Your Business?</h2>
                <p class="mt-4 max-w-xl mx-auto text-lg text-gray-600">Let's talk. A 30-minute discovery call is the first step to understanding your challenges and exploring how I can help. It's completely free and there's no obligation.</p>
                <div class="mt-10">
                    <a href="#" class="bg-blue-600 text-white hover:bg-blue-700 font-semibold py-3 px-8 rounded-lg text-lg transition-colors shadow-lg hover:shadow-xl">
                        Book Your Free Call Now
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-800 text-white">
        <div class="container mx-auto px-6 py-12 text-center">
            <h2 class="text-3xl font-bold">Contact Me</h2>
            <p class="mt-4 max-w-xl mx-auto text-gray-300">You can reach me via email or connect with me on LinkedIn.</p>
            <div class="mt-8 flex justify-center space-x-6">
                <a href="#" class="text-gray-400 hover:text-white"><i data-lucide="mail" class="w-7 h-7"></i></a>
                <a href="#" class="text-gray-400 hover:text-white"><i data-lucide="linkedin" class="w-7 h-7"></i></a>
                <a href="#" class="text-gray-400 hover:text-white"><i data-lucide="twitter" class="w-7 h-7"></i></a>
            </div>
            <div class="mt-12 border-t border-gray-700 pt-8 text-sm text-gray-400">
                <p>&copy; 2025 Tunde Adebayo Consulting. Powered by Ervop.</p>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
