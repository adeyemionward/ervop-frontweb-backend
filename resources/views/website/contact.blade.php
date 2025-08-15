@extends('layout.master')
@section('content')

    <!-- Main Content Centered -->
    <main class="flex-grow flex items-center justify-center py-12 px-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden grid md:grid-cols-2 border border-gray-200">
        
        <!-- Left side -->
        <div class="bg-gradient-to-tr from-blue-600 via-purple-600 to-pink-500 text-white p-10 flex flex-col justify-center">
          <h2 class="text-3xl font-bold mb-4">Get in Touch</h2>
          <p class="text-lg text-purple-100">We’d love to hear from you. Fill out the form and we’ll get back to you soon!</p>
          <div class="mt-8 space-y-6 text-white">
            <div class="flex items-center space-x-3">
                <i data-lucide="mail" class="w-5 h-5"></i>
                <span>contact@aishabello.com</span>
            </div>
            <div class="flex items-center space-x-3">
                <i data-lucide="phone" class="w-5 h-5"></i>
                <span>+234 812 345 6789</span>
            </div>
             <div class="flex items-start space-x-3">
                <i data-lucide="map-pin" class="w-5 h-5 mt-1"></i>
                <span>123, Rainbow Street, Lagos, Nigeria</span>
            </div>
          </div>
        </div>

        <!-- Right side: Contact Form -->
        <div class="p-10">
          <form class="space-y-6">
            <div>
              <label class="block text-gray-700 font-semibold mb-2">Name</label>
              <input type="text" class="w-full p-3 rounded-lg border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Your Name" />
            </div>
            <div>
              <label class="block text-gray-700 font-semibold mb-2">Email</label>
              <input type="email" class="w-full p-3 rounded-lg border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="you@example.com" />
            </div>
            <div>
              <label class="block text-gray-700 font-semibold mb-2">Message</label>
              <textarea rows="4" class="w-full p-3 rounded-lg border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Type your message here..."></textarea>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-500 text-white px-6 py-3 rounded-lg font-bold hover:from-pink-500 hover:to-red-500 transition duration-300 shadow-lg">
              Send Message
            </button>
          </form>
        </div>

      </div>
    </main>
@endsection
