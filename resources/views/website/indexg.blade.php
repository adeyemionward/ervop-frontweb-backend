<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Seller Landing Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-white text-gray-800">

  <!-- Hero Section -->
  <section class="relative h-[90vh] flex items-center justify-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1607083206173-8a2a5a7b5b2d?auto=format&fit=crop&w=1470&q=80');">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative z-10 text-center text-white px-6 max-w-2xl">
      <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Your One-Stop Shop for Quality Products & Services</h1>
      <p class="mb-6 text-lg">Discover top-selling items and book professional services – all in one place.</p>
      <div class="flex flex-col sm:flex-row justify-center gap-4">
        <a href="#products" class="bg-white text-purple-700 font-semibold px-6 py-3 rounded-full hover:bg-purple-100 transition">Explore Products</a>
        <a href="#services" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-3 rounded-full transition">Book a Service</a>
      </div>
    </div>
  </section>

  <!-- Product Categories -->
  <section class="py-16 px-6 bg-gray-50">
    <div class="container mx-auto max-w-6xl">
      <h2 class="text-3xl font-bold text-center mb-10">Product Categories</h2>
      <div class="grid md:grid-cols-3 gap-8 text-center">
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-2">Fashion</h3>
          <p class="text-gray-600">Trendy clothing, shoes, and accessories.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-2">Electronics</h3>
          <p class="text-gray-600">Gadgets, phones, and tech accessories.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-2">Home & Living</h3>
          <p class="text-gray-600">Furniture, decor, and lifestyle essentials.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured Products -->
  <section id="products" class="py-16 px-6">
    <div class="container mx-auto max-w-6xl">
      <h2 class="text-3xl font-bold text-center mb-10">Featured Products</h2>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white border rounded-xl overflow-hidden shadow hover:shadow-lg transition">
          <img src="https://via.placeholder.com/400x250" alt="Product 1" class="w-full h-52 object-cover" />
          <div class="p-4">
            <h3 class="font-semibold text-lg">Product Name 1</h3>
            <p class="text-gray-500 mt-1">₦10,000</p>
          </div>
        </div>
        <div class="bg-white border rounded-xl overflow-hidden shadow hover:shadow-lg transition">
          <img src="https://via.placeholder.com/400x250" alt="Product 2" class="w-full h-52 object-cover" />
          <div class="p-4">
            <h3 class="font-semibold text-lg">Product Name 2</h3>
            <p class="text-gray-500 mt-1">₦18,500</p>
          </div>
        </div>
        <div class="bg-white border rounded-xl overflow-hidden shadow hover:shadow-lg transition">
          <img src="https://via.placeholder.com/400x250" alt="Product 3" class="w-full h-52 object-cover" />
          <div class="p-4">
            <h3 class="font-semibold text-lg">Product Name 3</h3>
            <p class="text-gray-500 mt-1">₦7,800</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Professional Services Section -->
  <section id="services" class="py-16 px-6 bg-purple-50">
    <div class="container mx-auto max-w-6xl">
      <h2 class="text-3xl font-bold text-center mb-10 text-purple-800">Professional Services</h2>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center">
          <img src="https://via.placeholder.com/120" alt="Service 1" class="mx-auto mb-4 rounded-full" />
          <h3 class="text-xl font-semibold text-purple-700 mb-2">Home Cleaning</h3>
          <p class="text-gray-600">Top-rated professionals for sparkling clean homes.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center">
          <img src="https://via.placeholder.com/120" alt="Service 2" class="mx-auto mb-4 rounded-full" />
          <h3 class="text-xl font-semibold text-purple-700 mb-2">Electrician Services</h3>
          <p class="text-gray-600">Certified experts for your electrical needs.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center">
          <img src="https://via.placeholder.com/120" alt="Service 3" class="mx-auto mb-4 rounded-full" />
          <h3 class="text-xl font-semibold text-purple-700 mb-2">Tailoring</h3>
          <p class="text-gray-600">Custom stitching and adjustments by pros.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- About the Shop -->
  <section class="py-16 px-6 bg-gray-100">
    <div class="container mx-auto max-w-5xl text-center">
      <h2 class="text-3xl font-bold mb-6
