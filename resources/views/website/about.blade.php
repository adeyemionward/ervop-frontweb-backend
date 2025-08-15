@extends('layout.master')
@section('content')

        <!-- Hero Section -->
        <section class="py-20 md:py-32 bg-gray-50 flex items-center justify-center">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 leading-tight">
                    Weaving Tradition with Modern Design.
                </h1>
                <p class="mt-6 max-w-3xl mx-auto text-lg md:text-xl text-gray-600">
                    We are a team of artisans and strategists passionate about celebrating Nigerian culture through beautiful products and expert services.
                </p>
            </div>
        </section>

        <!-- Our Story Section -->
        <section class="py-20">
            <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <img src="https://placehold.co/600x700/e0f2fe/0891b2?text=Our+Workshop" alt="Our Workshop" class="rounded-xl shadow-xl w-full h-full object-cover">
                </div>
                <div>
                    <span class="text-blue-600 font-semibold">Our Story</span>
                    <h2 class="mt-3 text-3xl font-bold text-gray-900">From a Small Workshop in Lagos to a Global Vision</h2>
                    <p class="mt-4 text-lg text-gray-600">
                        Aisha Bello started this brand with a single sewing machine and a powerful idea: to share the beauty of Nigerian craftsmanship with the world. What began as a solo hustle has grown into a collective of passionate designers, marketers, and consultants.
                    </p>
                    <p class="mt-4 text-lg text-gray-600">
                        Our journey is one of passion and persistence. We believe in quality over quantity, in sustainable practices, and in building a brand that not only looks good but also does good for our community.
                    </p>
                </div>
            </div>
        </section>


          <!-- Our Mission & Vision -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-2 gap-12">
            <div>
                <i data-lucide="gem" class="w-10 h-10 text-blue-600"></i>
                <h3 class="mt-5 text-2xl font-bold text-gray-900">Our Mission</h3>
                <p class="mt-3 text-gray-600">To empower local artisans and showcase the richness of African design on a global stage through high-quality products and services.</p>
            </div>
            <div >
                <i data-lucide="eye" class="w-10 h-10 text-blue-600"></i>
                <h3 class="mt-5 text-2xl font-bold text-gray-900">Our Vision</h3>
                <p class="mt-3 text-gray-600">To be the leading global destination for authentic, contemporary African design and creative consulting.</p>
            </div>
        </div>
    </section>

  <!-- Core Values -->
  <section class="bg-gray-100 py-16">
    <div class="max-w-6xl mx-auto px-4 text-center">
      <h2 class="text-3xl font-bold mb-10 text-gray-800">Our Core Values</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-xl shadow-md">
          <h3 class="text-xl font-semibold mb-2 text-orange-600">Innovation</h3>
          <p class="text-gray-600">We believe in constant evolution and use the latest tech to solve real business problems.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md">
          <h3 class="text-xl font-semibold mb-2 text-orange-600">Integrity</h3>
          <p class="text-gray-600">We hold ourselves accountable to our clients and partners with honesty and transparency.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md">
          <h3 class="text-xl font-semibold mb-2 text-orange-600">Customer Success</h3>
          <p class="text-gray-600">We only succeed when our clients succeed. Your goals are our goals.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Optional: Meet the Team -->
  <section class="py-16">
    <div class="max-w-6xl mx-auto px-4 text-center">
      <h2 class="text-3xl font-bold mb-10 text-gray-800">Meet the Team</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
        <!-- Team Member -->
        <div class="bg-white shadow-lg rounded-lg p-6">
          <img src="https://via.placeholder.com/150" class="w-24 h-24 mx-auto rounded-full mb-4" alt="Team Member">
          <h3 class="text-lg font-semibold text-gray-900">Jane Doe</h3>
          <p class="text-sm text-orange-600 mb-1">Co-Founder & CEO</p>
          <p class="text-gray-500 text-sm">Product strategist and growth hacker.</p>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6">
          <img src="https://via.placeholder.com/150" class="w-24 h-24 mx-auto rounded-full mb-4" alt="Team Member">
          <h3 class="text-lg font-semibold text-gray-900">John Smith</h3>
          <p class="text-sm text-orange-600 mb-1">Lead Developer</p>
          <p class="text-gray-500 text-sm">Laravel and messaging systems specialist.</p>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6">
          <img src="https://via.placeholder.com/150" class="w-24 h-24 mx-auto rounded-full mb-4" alt="Team Member">
          <h3 class="text-lg font-semibold text-gray-900">Emily Chen</h3>
          <p class="text-sm text-orange-600 mb-1">UI/UX Designer</p>
          <p class="text-gray-500 text-sm">Designs clean, conversion-focused interfaces.</p>
        </div>
      </div>
    </div>
  </section>
@endsection
