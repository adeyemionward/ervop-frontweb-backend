@extends('layout.master')
@section('content')
    <style>
        
        html {
            scroll-behavior: smooth;
        }
        /* Simple transition for portfolio items */
        .portfolio-item {
            transition: all 0.3s ease-in-out;
        }
    </style>
    

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-12">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900">Our Work & Case Studies</h1>
            <p class="mt-3 text-lg text-gray-600 max-w-2xl mx-auto">A showcase of our creative projects, successful partnerships, and the results we've delivered.</p>
        </div>

        <!-- Filter Tabs -->
        <div class="flex justify-center mb-10">
            <div class="flex space-x-2 bg-gray-100 p-1 rounded-lg">
                <button class="filter-btn bg-white text-blue-600 shadow-sm px-4 py-2 rounded-md text-sm font-semibold">All Work</button>
                <button class="filter-btn text-gray-600 px-4 py-2 rounded-md text-sm font-semibold hover:bg-gray-200">Product Design</button>
                <button class="filter-btn text-gray-600 px-4 py-2 rounded-md text-sm font-semibold hover:bg-gray-200">Consulting</button>
                <button class="filter-btn text-gray-600 px-4 py-2 rounded-md text-sm font-semibold hover:bg-gray-200">Workshops</button>
            </div>
        </div>

        <!-- Portfolio Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Portfolio Item 1 (Product Design) -->
            <div class="portfolio-item group">
                <div class="rounded-xl overflow-hidden">
                    <img src="https://placehold.co/600x400/e9d5ff/4c1d95?text=Project+Alpha" alt="Project Alpha" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="mt-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-medium text-purple-700 bg-purple-100 px-2 py-1 rounded-full">Product Design</span>
                    </div>
                    <h3 class="mt-2 text-xl font-bold text-gray-900">Luxury Beaded Gown Collection</h3>
                    <p class="mt-1 text-gray-500">A full collection designed for a top Lagos boutique.</p>
                </div>
            </div>

            <!-- Portfolio Item 2 (Consulting) -->
            <div class="portfolio-item group">
                <div class="rounded-xl overflow-hidden">
                    <img src="https://placehold.co/600x400/dbeafe/1e3a8a?text=Case+Study" alt="Case Study" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="mt-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-medium text-blue-700 bg-blue-100 px-2 py-1 rounded-full">Consulting</span>
                    </div>
                    <h3 class="mt-2 text-xl font-bold text-gray-900">Market Entry Strategy for Brand X</h3>
                    <p class="mt-1 text-gray-500">Increased client's market share by 15% in 6 months.</p>
                </div>
            </div>

            <!-- Portfolio Item 3 (Product Design) -->
            <div class="portfolio-item group">
                <div class="rounded-xl overflow-hidden">
                    <img src="https://placehold.co/600x400/fef9c3/b45309?text=Project+Beta" alt="Project Beta" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="mt-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-medium text-purple-700 bg-purple-100 px-2 py-1 rounded-full">Product Design</span>
                    </div>
                    <h3 class="mt-2 text-xl font-bold text-gray-900">Handcrafted Leather Bag Line</h3>
                    <p class="mt-1 text-gray-500">A new line of bags featured in a major fashion magazine.</p>
                </div>
            </div>

            <!-- Portfolio Item 4 (Workshops) -->
            <div class="portfolio-item group">
                <div class="rounded-xl overflow-hidden">
                    <img src="https://placehold.co/600x400/dcfce7/166534?text=Workshop" alt="Workshop" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="mt-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-medium text-green-700 bg-green-100 px-2 py-1 rounded-full">Workshops</span>
                    </div>
                    <h3 class="mt-2 text-xl font-bold text-gray-900">Adire Making Workshop</h3>
                    <p class="mt-1 text-gray-500">Trained 50+ aspiring designers in traditional textile techniques.</p>
                </div>
            </div>

            <!-- Add more portfolio items as needed -->
             <div class="portfolio-item group">
                <div class="rounded-xl overflow-hidden">
                    <img src="https://placehold.co/600x400/fee2e2/b91c1c?text=Project+Gamma" alt="Project Gamma" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="mt-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-medium text-purple-700 bg-purple-100 px-2 py-1 rounded-full">Product Design</span>
                    </div>
                    <h3 class="mt-2 text-xl font-bold text-gray-900">Aso-Oke Wedding Collection</h3>
                    <p class="mt-1 text-gray-500">Bespoke designs for a high-profile wedding event.</p>
                </div>
            </div>
             <div class="portfolio-item group">
                <div class="rounded-xl overflow-hidden">
                    <img src="https://placehold.co/600x400/e0f2fe/0891b2?text=Case+Study+2" alt="Case Study 2" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="mt-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-medium text-blue-700 bg-blue-100 px-2 py-1 rounded-full">Consulting</span>
                    </div>
                    <h3 class="mt-2 text-xl font-bold text-gray-900">Operational Efficiency for SME</h3>
                    <p class="mt-1 text-gray-500">Reduced operational costs by 25% through process automation.</p>
                </div>
            </div>

        </div>
    </main>
@endsection
