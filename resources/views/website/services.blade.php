@extends('layout.master')
@section('content')
        <!-- Hero Section -->
        <section class="py-20 md:py-32 bg-gray-50">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 leading-tight">
                    Expert Services to Elevate Your Brand
                </h1>
                <p class="mt-6 max-w-3xl mx-auto text-lg md:text-xl text-gray-600">
                    From personal styling to bespoke design, we offer a range of professional services to help you achieve your creative vision.
                </p>
            </div>
        </section>


  <!-- Services Grid -->
  <section class="py-4">
    <div class="max-w-7xl mx-auto px-4">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
        
        <!-- Service Card -->
        <div class="bg-white shadow-lg rounded-2xl p-8 hover:shadow-xl transition">
          <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center text-orange-600 mb-4">
            <!-- Example Icon -->
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M3 5h18M9 3v2m6-2v2m-8 4h10M4 15h16M4 19h16" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-2">WhatsApp Automation</h3>
          <p class="text-gray-600">Automate messages, responses, and campaigns directly on WhatsApp to improve engagement.</p>
        </div>

        <!-- Service Card -->
        <div class="bg-white shadow-lg rounded-2xl p-8 hover:shadow-xl transition">
          <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center text-orange-600 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M8 16h8M8 12h8m-6 4v1a2 2 0 002 2h4a2 2 0 002-2v-1" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-2">Chatbot Integration</h3>
          <p class="text-gray-600">Deploy intelligent chatbots that respond instantly to customer queries and guide them through your services.</p>
        </div>

        <!-- Service Card -->
        <div class="bg-white shadow-lg rounded-2xl p-8 hover:shadow-xl transition">
          <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center text-orange-600 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M3 7h18M3 12h18M3 17h18" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-2">Broadcast Messaging</h3>
          <p class="text-gray-600">Send bulk messages to your audience with smart targeting and performance tracking.</p>
        </div>

        <!-- Add More Cards Below -->
        <div class="bg-white shadow-lg rounded-2xl p-8 hover:shadow-xl transition">
          <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center text-orange-600 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-2">CRM Integration</h3>
          <p class="text-gray-600">Integrate with your favorite CRM systems and keep customer data and conversations in sync.</p>
        </div>

        <div class="bg-white shadow-lg rounded-2xl p-8 hover:shadow-xl transition">
          <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center text-orange-600 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M12 8v4l3 3" />
              <circle cx="12" cy="12" r="10" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-2">Analytics Dashboard</h3>
          <p class="text-gray-600">Track all your messaging campaigns and customer interactions from one centralized dashboard.</p>
        </div>

        <div class="bg-white shadow-lg rounded-2xl p-8 hover:shadow-xl transition">
          <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center text-orange-600 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M15 17h5l-1.405-1.405M4 4l16 16M19 5l-7 7" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-2">API Access</h3>
          <p class="text-gray-600">Use our developer-friendly API to integrate WhatsApp features into your existing systems.</p>
        </div>

      </div>
    </div>
  </section>

        <!-- Our Process Section -->
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Our Simple Process</h2>
                    <p class="mt-3 text-lg text-gray-600">A clear and collaborative journey to achieve your creative goals.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 max-w-5xl mx-auto">
                    <!-- Step 1 -->
                    <div class="text-center relative process-step">
                        <div class="bg-blue-100 w-20 h-20 rounded-full mx-auto flex items-center justify-center relative z-10">
                            <i data-lucide="calendar-check" class="w-10 h-10 text-blue-600"></i>
                        </div>
                        <h3 class="mt-6 text-xl font-bold">1. Book a Discovery Call</h3>
                        <p class="mt-2 text-gray-600">Schedule a free call to discuss your challenges and vision.</p>
                    </div>
                    <!-- Step 2 -->
                    <div class="text-center relative process-step">
                        <div class="bg-blue-100 w-20 h-20 rounded-full mx-auto flex items-center justify-center relative z-10">
                            <i data-lucide="file-text" class="w-10 h-10 text-blue-600"></i>
                        </div>
                        <h3 class="mt-6 text-xl font-bold">2. Receive a Custom Proposal</h3>
                        <p class="mt-2 text-gray-600">We'll deliver a tailored strategy and a clear proposal.</p>
                    </div>
                    <!-- Step 3 -->
                    <div class="text-center relative process-step">
                        <div class="bg-blue-100 w-20 h-20 rounded-full mx-auto flex items-center justify-center relative z-10">
                            <i data-lucide="rocket" class="w-10 h-10 text-blue-600"></i>
                        </div>
                        <h3 class="mt-6 text-xl font-bold">3. Execute & Achieve Results</h3>
                        <p class="mt-2 text-gray-600">We'll work together to bring your vision to life.</p>
                    </div>
                </div>
            </div>
        </section>
@endsection
