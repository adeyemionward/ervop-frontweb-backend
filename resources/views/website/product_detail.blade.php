@extends('layout.master')
@section('content')
    <style>
        
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
        }
        .accordion-button.active + .accordion-content {
            max-height: 200px; /* Adjust as needed */
        }
        .accordion-button.active .icon-chevron {
            transform: rotate(180deg);
        }
    </style>
    <!-- Main Content -->
    <main class="container mx-auto px-6 py-12 md:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            
            <!-- Left Column: Image Gallery -->
            <div class="space-y-4">
                <div class="bg-gray-100 rounded-xl overflow-hidden h-96 lg:h-[500px]">
                    <img id="main-product-image" src="https://placehold.co/600x600/e9d5ff/4c1d95?text=Gown+1" alt="Luxury Beaded Gown" class="w-full h-full object-cover">
                </div>
                <div class="grid grid-cols-4 gap-4">
                    <div class="bg-gray-100 rounded-lg overflow-hidden aspect-square cursor-pointer border-2 border-orange-500">
                        <img src="https://placehold.co/200x200/e9d5ff/4c1d95?text=Gown+1" alt="Thumbnail 1" class="w-full h-full object-cover gallery-thumb">
                    </div>
                    <div class="bg-gray-100 rounded-lg overflow-hidden aspect-square cursor-pointer border-2 border-transparent hover:border-orange-500">
                        <img src="https://placehold.co/200x200/e9d5ff/4c1d95?text=Gown+2" alt="Thumbnail 2" class="w-full h-full object-cover gallery-thumb">
                    </div>
                    <div class="bg-gray-100 rounded-lg overflow-hidden aspect-square cursor-pointer border-2 border-transparent hover:border-orange-500">
                        <img src="https://placehold.co/200x200/e9d5ff/4c1d95?text=Gown+3" alt="Thumbnail 3" class="w-full h-full object-cover gallery-thumb">
                    </div>
                    <div class="bg-gray-100 rounded-lg overflow-hidden aspect-square cursor-pointer border-2 border-transparent hover:border-orange-500">
                        <img src="https://placehold.co/200x200/e9d5ff/4c1d95?text=Gown+4" alt="Thumbnail 4" class="w-full h-full object-cover gallery-thumb">
                    </div>
                </div>
            </div>

            <!-- Right Column: Product Details -->
            <div>
                <span class="text-sm font-semibold text-green-600 bg-green-100 px-3 py-1 rounded-full">In Stock</span>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-4">Luxury Beaded Gown</h1>
                <p class="mt-4 text-3xl font-bold text-gray-900">₦75,000</p>
                <p class="mt-6 text-gray-600 leading-relaxed">
                    A beautifully handcrafted genuine beaded gown, perfect for special occasions. Made with locally sourced silk and materials in Lagos, Nigeria. Features a durable inner lining and a secure zip closure.
                </p>

                <div class="mt-8 pt-6 border-t border-gray-200 space-y-6">
                    <div class="flex items-center space-x-4">
                        <p class="font-semibold">Quantity:</p>
                        <div class="flex items-center border border-gray-300 rounded-lg">
                            <button id="qty-minus" class="px-3 py-2 text-gray-500 hover:bg-gray-100 rounded-l-lg">-</button>
                            <input id="qty-input" type="text" value="1" class="w-12 text-center border-l border-r focus:outline-none">
                            <button id="qty-plus" class="px-3 py-2 text-gray-500 hover:bg-gray-100 rounded-r-lg">+</button>
                        </div>
                    </div>

                    <!-- Delivery Information Form -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Details for WhatsApp Order</h3>
                        <div class="space-y-4">
                             <div>
                                <label for="full-name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" id="full-name" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            </div>
                             <div>
                                <label for="whatsapp-number" class="block text-sm font-medium text-gray-700">WhatsApp Phone Number</label>
                                <input type="tel" id="whatsapp-number" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="delivery-address" class="block text-sm font-medium text-gray-700">Delivery Address</label>
                                <textarea id="delivery-address" rows="3" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm"></textarea>
                            </div>
                             <div>
                                <label for="lga" class="block text-sm font-medium text-gray-700">Local Government Area (LGA)</label>
                                <input type="text" id="lga" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            </div>
                             <!-- NEW: Abandoned Cart Reminder Checkbox -->
                            <div class="flex items-start pt-2">
                                <div class="flex items-center h-5">
                                    <input id="reminder-checkbox" name="reminder-checkbox" type="checkbox" class="h-4 w-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="reminder-checkbox" class="font-medium text-gray-700">Yes, send me a reminder on WhatsApp if I don't complete my order.</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button class="w-full bg-orange-500 text-white hover:bg-orange-600 font-semibold py-4 px-8 rounded-lg flex items-center justify-center transition-colors shadow-lg text-lg">
                        <i data-lucide="shopping-cart" class="w-6 h-6 mr-3"></i>
                        Order on WhatsApp
                    </button>
                </div>

                <!-- Accordion for more details -->
                <div class="mt-8 border-t border-gray-200 pt-6 space-y-4">
                    <div>
                        <button class="accordion-button w-full flex justify-between items-center text-left">
                            <h3 class="text-lg font-semibold text-gray-900">Product Details</h3>
                            <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500 icon-chevron transition-transform"></i>
                        </button>
                        <div class="accordion-content mt-4">
                            <p class="text-gray-600 text-sm">Fabric: 100% Silk with hand-sewn beads. <br>Care: Dry clean only.</p>
                        </div>
                    </div>
                    <div class="border-t pt-4">
                         <button class="accordion-button w-full flex justify-between items-center text-left">
                            <h3 class="text-lg font-semibold text-gray-900">Shipping & Returns</h3>
                            <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500 icon-chevron transition-transform"></i>
                        </button>
                        <div class="accordion-content mt-4">
                            <p class="text-gray-600 text-sm">Nationwide delivery available. 7-day return policy for unworn items.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- You Might Also Like Section -->
        <section class="py-20 mt-12 border-t border-gray-200">
             <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">You Might Also Like</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Related Product Card 1 -->
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
                <!-- Related Product Card 2 -->
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
                <!-- Related Product Card 3 -->
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
                <!-- Related Product Card 4 -->
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
            </div>
        </section>

    </main>

    <script>
        lucide.createIcons();

        // Image Gallery Logic
        const mainImage = document.getElementById('main-product-image');
        const thumbnails = document.querySelectorAll('.gallery-thumb');
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                // Update main image src
                mainImage.src = this.src.replace('200x200', '600x600');
                // Update active border
                thumbnails.forEach(t => t.parentElement.classList.remove('border-orange-500'));
                this.parentElement.classList.add('border-orange-500');
            });
        });

        // Quantity Selector Logic
        const qtyMinus = document.getElementById('qty-minus');
        const qtyPlus = document.getElementById('qty-plus');
        const qtyInput = document.getElementById('qty-input');
        qtyMinus.addEventListener('click', () => {
            let currentVal = parseInt(qtyInput.value);
            if (currentVal > 1) {
                qtyInput.value = currentVal - 1;
            }
        });
        qtyPlus.addEventListener('click', () => {
            let currentVal = parseInt(qtyInput.value);
            qtyInput.value = currentVal + 1;
        });

        // Accordion Logic
        const accordionButtons = document.querySelectorAll('.accordion-button');
        accordionButtons.forEach(button => {
            button.addEventListener('click', () => {
                button.classList.toggle('active');
            });
        });
    </script>
@endsection
