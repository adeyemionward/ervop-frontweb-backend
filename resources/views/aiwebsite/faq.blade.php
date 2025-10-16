<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Aisha Bello</title>
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
            <h1 class="text-2xl font-bold text-gray-900">Aisha Bello</h1>
            <nav class="hidden md:flex items-center space-x-8">
                <a href="#" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Home</a>
                <a href="#" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Shop</a>
                <a href="#" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Services</a>
                <a href="#" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Portfolio</a>
                <a href="#" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">About</a>
                <a href="#" class="text-blue-600 hover:text-blue-600 font-semibold transition-colors">FAQ</a>
            </nav>
            <a href="#" class="bg-blue-600 text-white hover:bg-blue-700 font-semibold py-2 px-5 rounded-lg transition-colors hidden md:flex">
                Book a Consultation
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="py-20 md:py-32 bg-gray-50">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 leading-tight">
                    Frequently Asked Questions
                </h1>
                <p class="mt-6 max-w-3xl mx-auto text-lg md:text-xl text-gray-600">
                    {{data_get($faqContent, 'faq.faq.faq.section_title', '')}}
                </p>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="py-20">
            <div class="container mx-auto px-6 max-w-3xl">
                <div class="space-y-8">
                    @php
                        $faqs = data_get($faqContent, 'faq.faq.faq.question', []);
                        $answers = data_get($faqContent, 'faq.faq.faq.answer', []);    
                    @endphp
                    <!-- FAQ Items -->
                    @foreach($faqs as $key => $question)
                        <div class="border-b border-gray-200 pb-4">
                            <button class="faq-question w-full flex justify-between items-center text-left">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $question }}</h3>
                                <i data-lucide="plus" class="w-5 h-5 text-blue-600 icon-plus transition-transform"></i>
                            </button>
                            <div class="faq-answer mt-4">
                                <p class="text-gray-600">
                                    {{ data_get($answers, $key, '') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-800 text-white">
        <div class="container mx-auto px-6 py-12 text-center">
            <h2 class="text-3xl font-bold">Still Have Questions?</h2>
            <p class="mt-4 max-w-xl mx-auto text-gray-300">We're here to help. Contact us directly for any inquiries.</p>
            <div class="mt-8">
                <a href="#" class="bg-blue-600 text-white hover:bg-blue-700 font-semibold py-3 px-8 rounded-lg text-lg transition-colors shadow-lg hover:shadow-xl">
                    Contact Us
                </a>
            </div>
            <div class="mt-12 border-t border-gray-700 pt-8 text-sm text-gray-400">
                <p>&copy; 2025 Aisha Bello. Powered by Ervop.</p>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();

        // FAQ Accordion Logic
        const faqQuestions = document.querySelectorAll('.faq-question');
        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                // Close other open questions
                faqQuestions.forEach(otherQuestion => {
                    if (otherQuestion !== question) {
                        otherQuestion.classList.remove('active');
                    }
                });
                // Toggle the clicked question
                question.classList.toggle('active');
            });
        });
    </script>
</body>
</html>
