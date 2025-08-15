@extends('layout.master')
@section('content')
        <!-- Hero Section -->
        <section class="py-20 md:py-32 bg-gray-50">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 leading-tight">
                    Frequently Asked Questions
                </h1>
                <p class="mt-6 max-w-3xl mx-auto text-lg md:text-xl text-gray-600">
                    Have a question? We've got answers. If you can't find what you're looking for, feel free to contact us directly.
                </p>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="py-20">
            <div class="container mx-auto px-6 max-w-3xl">
                <div class="space-y-8">
                    
                    <!-- FAQ Item 1 -->
                    <div class="border-b border-gray-200 pb-4">
                        <button class="faq-question w-full flex justify-between items-center text-left">
                            <h3 class="text-lg font-semibold text-gray-900">Do you ship products nationwide?</h3>
                            <i data-lucide="plus" class="w-5 h-5 text-blue-600 icon-plus transition-transform"></i>
                        </button>
                        <div class="faq-answer mt-4">
                            <p class="text-gray-600">Yes, we ship to all 36 states in Nigeria. We partner with reliable courier services to ensure your package arrives safely and on time. Delivery fees and times vary based on your location.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="border-b border-gray-200 pb-4">
                        <button class="faq-question w-full flex justify-between items-center text-left">
                            <h3 class="text-lg font-semibold text-gray-900">What is the process for a custom design service?</h3>
                            <i data-lucide="plus" class="w-5 h-5 text-blue-600 icon-plus transition-transform"></i>
                        </button>
                        <div class="faq-answer mt-4">
                            <p class="text-gray-600">Our custom design process begins with a free 30-minute discovery call to understand your vision. Afterwards, we provide a detailed proposal and quote. Once approved, we move through design mockups, material selection, and fittings to create your perfect bespoke piece.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="border-b border-gray-200 pb-4">
                        <button class="faq-question w-full flex justify-between items-center text-left">
                            <h3 class="text-lg font-semibold text-gray-900">What is your return policy for products?</h3>
                            <i data-lucide="plus" class="w-5 h-5 text-blue-600 icon-plus transition-transform"></i>
                        </button>
                        <div class="faq-answer mt-4">
                            <p class="text-gray-600">We offer a 7-day return policy for all ready-to-wear items, provided they are in their original, unworn condition with all tags attached. Please note that custom-made items are non-refundable.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="border-b border-gray-200 pb-4">
                        <button class="faq-question w-full flex justify-between items-center text-left">
                            <h3 class="text-lg font-semibold text-gray-900">How do I book a consultation?</h3>
                            <i data-lucide="plus" class="w-5 h-5 text-blue-600 icon-plus transition-transform"></i>
                        </button>
                        <div class="faq-answer mt-4">
                            <p class="text-gray-600">You can easily book a free discovery call or a paid consultation directly through our website. Simply navigate to the "Book a Consultation" page, select a service, and choose a date and time that works for you from our live calendar.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

@endsection
