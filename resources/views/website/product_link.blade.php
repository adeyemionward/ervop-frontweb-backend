@extends('layout.master')
@section('content')
    <style>
        
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
            background-color: #10b981; /* bg-emerald-500 */
            color: white;
        }
        .timeline-step.completed .timeline-content::after {
            background-color: #10b981; /* bg-emerald-500 */
        }
    </style>


    <!-- Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Adeyemi's Designs</h1>
            <a href="#" class="text-sm font-semibold text-orange-500 hover:underline">Back to Shop</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-12 md:py-20">
        <div class="max-w-4xl mx-auto">
            
            <!-- Order Header -->
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900">Thank you for your order!</h1>
                <p class="mt-3 text-lg text-gray-600">Order <span class="font-semibold text-orange-500">#1025</span> is currently being processed.</p>
            </div>

            <!-- Order Status Timeline -->
            <div class="mt-12">
                <ol class="relative space-y-8">
                    <!-- Step 1: Order Placed (Completed) -->
                    <li class="timeline-step completed">
                        <div class="flex items-start">
                            <div class="timeline-icon flex-shrink-0 w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                <i data-lucide="check" class="w-6 h-6"></i>
                            </div>
                            <div class="timeline-content ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Order Placed</h3>
                                <p class="text-sm text-gray-500">July 28, 2025</p>
                                <p class="mt-2 text-gray-600">We've received your order and are getting it ready.</p>
                            </div>
                        </div>
                    </li>
                    <!-- Step 2: Processing (Completed) -->
                    <li class="timeline-step completed">
                        <div class="flex items-start">
                            <div class="timeline-icon flex-shrink-0 w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                <i data-lucide="check" class="w-6 h-6"></i>
                            </div>
                            <div class="timeline-content ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Processing</h3>
                                <p class="text-sm text-gray-500">July 28, 2025</p>
                                <p class="mt-2 text-gray-600">Your items have been picked and are being prepared for shipment.</p>
                            </div>
                        </div>
                    </li>
                    <!-- Step 3: Shipped (Current Step) -->
                    <li class="timeline-step completed">
                        <div class="flex items-start">
                            <div class="timeline-icon flex-shrink-0 w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center ring-8 ring-white">
                                <i data-lucide="check" class="w-6 h-6"></i>
                            </div>
                            <div class="timeline-content ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Shipped</h3>
                                <p class="text-sm text-gray-500">July 29, 2025</p>
                                <p class="mt-2 text-gray-600">Your order is on its way! Tracking number: <span class="font-medium text-orange-500">GIGL12345678</span></p>
                            </div>
                        </div>
                    </li>
                    <!-- Step 4: Delivered (Future Step) -->
                    <li class="timeline-step">
                        <div class="flex items-start">
                            <div class="timeline-icon flex-shrink-0 w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                <i data-lucide="package" class="w-6 h-6 text-gray-500"></i>
                            </div>
                            <div class="timeline-content ml-4">
                                <h3 class="text-lg font-semibold text-gray-400">Delivered</h3>
                                <p class="text-sm text-gray-400">Estimated: July 31, 2025</p>
                            </div>
                        </div>
                    </li>
                </ol>
            </div>

            <!-- Order Details -->
            <div class="mt-16 pt-8 border-t border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Summary</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left: Items -->
                    <div>
                        <ul class="space-y-4">
                            <li class="flex items-center space-x-4">
                                <img src="https://placehold.co/80x80/e9d5ff/4c1d95?text=Gown" alt="Product" class="w-20 h-20 rounded-lg object-cover">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">Luxury Beaded Gown</p>
                                    <p class="text-sm text-gray-500">Qty: 1</p>
                                </div>
                                <p class="font-semibold text-gray-800">₦75,000</p>
                            </li>
                             <li class="flex items-center space-x-4">
                                <img src="https://placehold.co/80x80/fef9c3/b45309?text=Bag" alt="Product" class="w-20 h-20 rounded-lg object-cover">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">Leather Handbag</p>
                                    <p class="text-sm text-gray-500">Qty: 1</p>
                                </div>
                                <p class="font-semibold text-gray-800">₦25,000</p>
                            </li>
                        </ul>
                        <div class="mt-6 pt-6 border-t border-gray-200 space-y-2 text-sm">
                            <div class="flex justify-between"><p class="text-gray-600">Subtotal</p><p class="font-medium">₦100,000</p></div>
                            <div class="flex justify-between"><p class="text-gray-600">Shipping</p><p class="font-medium">₦5,000</p></div>
                            <div class="flex justify-between text-base"><p class="font-semibold">Total</p><p class="font-bold">₦105,000</p></div>
                        </div>
                    </div>
                    <!-- Right: Customer Info -->
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h3>
                        <div class="space-y-4 text-sm">
                            <div>
                                <p class="text-gray-500">Shipping Address</p>
                                <p class="font-medium text-gray-800">Tunde Adebayo<br>123 Allen Avenue<br>Ikeja, Lagos, 100282</p>
                            </div>
                             <div>
                                <p class="text-gray-500">Payment Method</p>
                                <p class="font-medium text-gray-800">Paystack Card (**** **** **** 4242)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
