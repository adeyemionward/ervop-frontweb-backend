<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us - Aisha Bello</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
      body {
          font-family: 'Inter', sans-serif;
      }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

     <header class="sticky top-0 bg-white/70 backdrop-blur-md z-50 border-b border-gray-200">
        <div class="bg-white/50 shadow-lg border border-gray-200/80">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-900">Adeyemi's</h1>
                <nav class="hidden lg:flex items-center space-x-8">
                    <a href="index.html" class="text-gray-600 hover:text-orange-500 font-medium transition-colors">Home</a>
                    <a href="about.html" class="text-gray-600 hover:text-orange-500 font-medium transition-colors">About</a>
                    <a href="services.html" class="text-gray-600 hover:text-orange-500 font-medium transition-colors">Services</a>
                    <a href="portfolio.html" class="text-gray-600 hover:text-orange-500 font-medium transition-colors">Portfolio</a>
                    <a href="faq.html" class="text-gray-600 hover:text-orange-500 font-medium transition-colors">Faq</a>
                    <a href="contact.html" class="text-gray-600 hover:text-orange-500 font-medium transition-colors">Contact</a>
                </nav>
                <div class="flex items-center space-x-4">
                    <a href="#" class="bg-blue-600 text-white hover:bg-blue-700 font-semibold py-2 px-5 rounded-lg transition-colors hidden md:flex">
                        Book a Consultation
                    </a>
                    
                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-button" class="lg:hidden text-gray-500 hover:text-orange-500">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu Panel -->
        <div id="mobile-menu" class="hidden lg:hidden mt-2 rounded-2xl bg-white/95 backdrop-blur-md shadow-lg border border-gray-200/80">
            <nav class="flex flex-col p-4 space-y-2">
                <a href="index.html" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md">Home</a>
                <a href="about.html" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md">About</a>
                <a href="services.html" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md">Services</a>
                <a href="portfolio.html" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md">Portfolio</a>
                <a href="faq.html" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md">Faq</a>
                <a href="contact.html" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md">Contact</a>

                <a href="#" class="bg-blue-600 text-white hover:bg-blue-700 font-semibold py-2 px-5 rounded-lg transition-colors md:flex">
                    Book a Consultation
                </a>
            </nav>
          
        </div>
    </header>


    <!-- Main Content Centered -->
    <main class="flex-grow flex items-center justify-center py-12 px-4 bg-gray-50">
      <div class="w-full max-w-5xl grid md:grid-cols-2 gap-8 bg-white rounded-3xl shadow-lg overflow-hidden">

        <!-- Left side: Contact Info -->
        <div class="p-10 flex flex-col justify-center space-y-6 bg-gray-100">
          <h2 class="text-3xl font-bold text-gray-900">Get in Touch</h2>
          <p class="text-gray-700">We’d love to hear from you. Fill out the form and we’ll get back to you as soon as possible!</p>

          <div class="space-y-4">
            <div class="flex items-center space-x-3 text-gray-800">
              <i data-lucide="mail" class="w-5 h-5 text-purple-500"></i>
              <span>contact@aishabello.com</span>
            </div>
            <div class="flex items-center space-x-3 text-gray-800">
              <i data-lucide="phone" class="w-5 h-5 text-purple-500"></i>
              <span>+234 812 345 6789</span>
            </div>
            <div class="flex items-start space-x-3 text-gray-800">
              <i data-lucide="map-pin" class="w-5 h-5 mt-1 text-purple-500"></i>
              <span>123, Rainbow Street, Lagos, Nigeria</span>
            </div>
          </div>
        </div>

        <!-- Right side: Contact Form -->
        <div class="p-10 flex flex-col justify-center bg-white">
          <h2 class="text-2xl font-bold text-gray-900 mb-6">Send Us a Message</h2>
          <form class="space-y-5">
            <div>
              <label class="block text-gray-700 font-medium mb-2">Name</label>
              <input type="text" placeholder="Your Name"
                class="w-full p-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition"/>
            </div>
            <div>
              <label class="block text-gray-700 font-medium mb-2">Email</label>
              <input type="email" placeholder="you@example.com"
                class="w-full p-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition"/>
            </div>
            <div>
              <label class="block text-gray-700 font-medium mb-2">Message</label>
              <textarea rows="5" placeholder="Type your message..."
                class="w-full p-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition resize-none"></textarea>
            </div>
            <button type="submit"
              class="w-full bg-purple-600 text-white py-3 rounded-xl font-semibold hover:bg-purple-700 transition duration-300 shadow-lg">
              Send Message
            </button>
          </form>
        </div>

      </div>
    </main>

    <footer id="contact" class="bg-gray-900 text-white">
        <div class="container mx-auto px-6 py-12 text-center">
            <h2 class="text-3xl font-bold">Get in Touch</h2>
            <p class="mt-4 max-w-xl mx-auto text-gray-300">Have a question or a custom request? We'd love to hear from you. Follow us on social media or send us a message.</p>
            <div class="mt-8 flex justify-center space-x-6">
                <a href="#" class="text-gray-400 hover:text-white"><i data-lucide="instagram" class="w-7 h-7"></i></a>
                <a href="#" class="text-gray-400 hover:text-white"><i data-lucide="facebook" class="w-7 h-7"></i></a>
                <a href="#" class="text-gray-400 hover:text-white"><i data-lucide="twitter" class="w-7 h-7"></i></a>
            </div>
            <div class="mt-12 border-t border-gray-700 pt-8 text-sm text-gray-400">
                <p>&copy; 2025 Adeyemi's Designs. Powered by Ervop.</p>
            </div>
        </div>
    </footer>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
