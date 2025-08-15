@extends('layout.master')
@section('content')

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-12">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900">All Products</h1>
            <p class="mt-3 text-lg text-gray-600">Explore our full collection of handcrafted designs.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar: Filters -->
            <aside class="lg:col-span-1">
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Filters</h3>
                    
                    <!-- Category Filter -->
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-3">Category</h4>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input id="cat-gowns" type="checkbox" class="h-4 w-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500">
                                <label for="cat-gowns" class="ml-3 text-gray-600">Gowns</label>
                            </div>
                            <div class="flex items-center">
                                <input id="cat-bags" type="checkbox" class="h-4 w-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500">
                                <label for="cat-bags" class="ml-3 text-gray-600">Bags</label>
                            </div>
                            <div class="flex items-center">
                                <input id="cat-fabric" type="checkbox" class="h-4 w-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500">
                                <label for="cat-fabric" class="ml-3 text-gray-600">Fabric</label>
                            </div>
                            <div class="flex items-center">
                                <input id="cat-asooke" type="checkbox" class="h-4 w-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500">
                                <label for="cat-asooke" class="ml-3 text-gray-600">Aso-Oke</label>
                            </div>
                        </div>
                    </div>

                    <!-- Price Range Filter -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="font-semibold text-gray-800 mb-4">Price Range</h4>
                        <div class="relative">
                            <input type="range" min="0" max="100000" value="75000" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                            <div class="flex justify-between text-sm text-gray-500 mt-2">
                                <span>₦0</span>
                                <span>₦100,000+</span>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content: Product Grid -->
            <div class="lg:col-span-3">
                <!-- Sorting Bar -->
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-600">Showing <span class="font-semibold">12</span> of <span class="font-semibold">48</span> products</p>
                    <select class="border-gray-300 rounded-lg text-sm focus:ring-orange-500 focus:border-orange-500">
                        <option>Sort by: Newest</option>
                        <option>Sort by: Price (Low to High)</option>
                        <option>Sort by: Price (High to Low)</option>
                    </select>
                </div>

                <!-- Product Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                    <!-- Product Cards -->
                    <div class="bg-white rounded-xl overflow-hidden flex flex-col">
                        <img src="https://placehold.co/400x400/e9d5ff/4c1d95?text=Gown" alt="Product" class="w-full h-80 object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex-grow">
                                <h3 class="text-lg font-semibold text-gray-800">Luxury Beaded Gown</h3>
                                <p class="mt-2 text-xl font-bold text-gray-900">₦75,000</p>
                            </div>
                            <button class="mt-4 w-full bg-orange-500 text-white font-semibold py-3 px-4 rounded-lg flex items-center justify-center transition-colors hover:bg-orange-600 shadow-sm">
                                <i data-lucide="shopping-cart" class="w-5 h-5 mr-2"></i> Order on WhatsApp
                            </button>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl overflow-hidden flex flex-col">
                        <img src="https://placehold.co/400x400/fef9c3/b45309?text=Bag" alt="Product" class="w-full h-80 object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                             <div class="flex-grow">
                                <h3 class="text-lg font-semibold text-gray-800">Leather Handbag</h3>
                                <p class="mt-2 text-xl font-bold text-gray-900">₦25,000</p>
                            </div>
                            <button class="mt-4 w-full bg-orange-500 text-white font-semibold py-3 px-4 rounded-lg flex items-center justify-center transition-colors hover:bg-orange-600 shadow-sm">
                                <i data-lucide="shopping-cart" class="w-5 h-5 mr-2"></i> Order on WhatsApp
                            </button>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl overflow-hidden flex flex-col">
                        <img src="https://placehold.co/400x400/dcfce7/166534?text=Fabric" alt="Product" class="w-full h-80 object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex-grow">
                                <h3 class="text-lg font-semibold text-gray-800">Ankara Print Fabric</h3>
                                <p class="mt-2 text-xl font-bold text-gray-900">₦12,000</p>
                            </div>
                            <button class="mt-4 w-full bg-orange-500 text-white font-semibold py-3 px-4 rounded-lg flex items-center justify-center transition-colors hover:bg-orange-600 shadow-sm">
                                <i data-lucide="shopping-cart" class="w-5 h-5 mr-2"></i> Order on WhatsApp
                            </button>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl overflow-hidden flex flex-col">
                        <img src="https://placehold.co/400x400/fee2e2/b91c1c?text=Aso-Oke" alt="Product" class="w-full h-80 object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex-grow">
                                <h3 class="text-lg font-semibold text-gray-800">Aso-Oke Head Tie</h3>
                                <p class="mt-2 text-xl font-bold text-gray-900">₦15,000</p>
                            </div>
                            <button class="mt-4 w-full bg-orange-500 text-white font-semibold py-3 px-4 rounded-lg flex items-center justify-center transition-colors hover:bg-orange-600 shadow-sm">
                                <i data-lucide="shopping-cart" class="w-5 h-5 mr-2"></i> Order on WhatsApp
                            </button>
                        </div>
                    </div>
                     <div class="bg-white rounded-xl overflow-hidden flex flex-col">
                        <img src="https://placehold.co/400x400/e0f2fe/0891b2?text=Agbada" alt="Product" class="w-full h-80 object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex-grow">
                                <h3 class="text-lg font-semibold text-gray-800">Men's Agbada Set</h3>
                                <p class="mt-2 text-xl font-bold text-gray-900">₦90,000</p>
                            </div>
                            <button class="mt-4 w-full bg-orange-500 text-white font-semibold py-3 px-4 rounded-lg flex items-center justify-center transition-colors hover:bg-orange-600 shadow-sm">
                                <i data-lucide="shopping-cart" class="w-5 h-5 mr-2"></i> Order on WhatsApp
                            </button>
                        </div>
                    </div>
                     <div class="bg-white rounded-xl overflow-hidden flex flex-col">
                        <img src="https://placehold.co/400x400/f3e8ff/581c87?text=Scarf" alt="Product" class="w-full h-80 object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex-grow">
                                <h3 class="text-lg font-semibold text-gray-800">Kente Pattern Scarf</h3>
                                <p class="mt-2 text-xl font-bold text-gray-900">₦8,000</p>
                            </div>
                            <button class="mt-4 w-full bg-orange-500 text-white font-semibold py-3 px-4 rounded-lg flex items-center justify-center transition-colors hover:bg-orange-600 shadow-sm">
                                <i data-lucide="shopping-cart" class="w-5 h-5 mr-2"></i> Order on WhatsApp
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    <nav class="flex items-center space-x-2">
                        <a href="#" class="px-3 py-1 rounded-md text-gray-500 hover:bg-gray-200">&larr;</a>
                        <a href="#" class="px-3 py-1 rounded-md text-white bg-orange-500">1</a>
                        <a href="#" class="px-3 py-1 rounded-md text-gray-700 hover:bg-gray-200">2</a>
                        <a href="#" class="px-3 py-1 rounded-md text-gray-700 hover:bg-gray-200">3</a>
                        <span class="px-3 py-1 text-gray-500">...</span>
                        <a href="#" class="px-3 py-1 rounded-md text-gray-700 hover:bg-gray-200">8</a>
                        <a href="#" class="px-3 py-1 rounded-md text-gray-700 hover:bg-gray-200">&rarr;</a>
                    </nav>
                </div>
            </div>
        </div>
    </main>
@endsection

  