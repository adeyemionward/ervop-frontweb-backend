<!DOCTYPE html>
<html lang="en" class="h-full m-0 p-0">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Stride Suite AI</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
        /* Custom styles if needed, but Tailwind should handle most */

        .text-gray-900 { color: #1a202c; } /* Darker text for headings */
        .text-gray-700 { color: #4a5568; } /* Regular text */
        .text-gray-500 { color: #a0aec0; } /* Lighter text for details/icons */
        .border-gray-200 { border-color: #edf2f7; } /* Subtle border */
    </style>
<body class="h-full min-h-screen bg-gradient-to-br from-purple-600 via-purple-700 to-purple-800 text-gray-900 m-0 p-0">


    <!-- Navbar -->
  <nav id="navbar" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-11/12 max-w-3xl px-6 py-2 bg-white/80 backdrop-blur-md rounded-full shadow-lg border border-white/30 transition-colors duration-300">
    <div class="flex items-center justify-between">
        <!-- Logo -->
        <a href="#" id="logo" class="text-2xl font-bold bg-gradient-to-r from-purple-500 to-pink-500 bg-clip-text text-transparent transition-colors duration-300">
            Ervop
        </a>

        <!-- Desktop Nav Links -->
        <div class="hidden md:flex items-center gap-6" id="nav-links">
            <a href="#" class="text-sm font-medium hover:text-purple-600">Home</a>
            <a href="#products" class="text-sm font-medium hover:text-purple-600">Products</a>
            <a href="#pricing" class="text-sm font-medium hover:text-purple-600">Pricing</a>
            <a href="#faq" class="text-sm font-medium hover:text-purple-600">FAQ</a>
        </div>

        <!-- Right Side Buttons -->
        <div class="flex items-center gap-3">
            <a href="#login" id="login-button" class="openModalBtn bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-full text-sm font-semibold">
                Join Waitlist
            </a>

            <!-- Mobile Menu Button -->
            <button id="menu-toggle" class="md:hidden focus:outline-none text-purple-600 transition-colors duration-300">
                <!-- Hamburger Icon -->
                <svg id="menu-icon" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <!-- Close Icon -->
                <svg id="close-icon" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Dropdown Menu (placed OUTSIDE navbar) -->
<div id="mobile-menu" class="hidden fixed top-20 left-1/2 transform -translate-x-1/2 w-11/12 max-w-3xl bg-white rounded-xl shadow-lg border border-gray-200 py-3 md:hidden z-40 transition-all duration-300">
    <a href="#" class="block px-5 py-2 text-sm font-medium text-purple-600 hover:bg-purple-50">Home</a>
    <a href="#products" class="block px-5 py-2 text-sm font-medium text-purple-600 hover:bg-purple-50">Products</a>
    <a href="#pricing" class="block px-5 py-2 text-sm font-medium text-purple-600 hover:bg-purple-50">Pricing</a>
    <a href="#faq" class="block px-5 py-2 text-sm font-medium text-purple-600 hover:bg-purple-50">FAQ</a>
</div>

<script>
    const navbar = document.getElementById('navbar');
    const logo = document.getElementById('logo');
    const navLinks = document.getElementById('nav-links');
    const loginButton = document.getElementById('login-button');
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    // Toggle mobile menu
    menuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    });

    // Scroll effect
    window.addEventListener('scroll', () => {
        if (window.scrollY > 600) {
            navbar.classList.add('bg-purple-600', 'border-purple-700');
            navbar.classList.remove('bg-white/80', 'border-white/30');

            logo.classList.remove('bg-gradient-to-r', 'from-purple-500', 'to-pink-500', 'bg-clip-text', 'text-transparent');
            logo.classList.add('text-white');

            navLinks.querySelectorAll('a').forEach(link => {
                link.classList.add('text-white');
                link.classList.remove('text-purple-600', 'hover:text-purple-600');
            });

            // Change button and icon color
            loginButton.classList.remove('bg-purple-600', 'hover:bg-purple-700');
            loginButton.classList.add('bg-pink-600', 'hover:bg-pink-700');
            menuToggle.classList.remove('text-purple-600');
            menuToggle.classList.add('text-white');

        } else {
            navbar.classList.add('bg-white/80', 'border-white/30');
            navbar.classList.remove('bg-purple-600', 'border-purple-700');

            logo.classList.add('bg-gradient-to-r', 'from-purple-500', 'to-pink-500', 'bg-clip-text', 'text-transparent');
            logo.classList.remove('text-white');

            navLinks.querySelectorAll('a').forEach(link => {
                link.classList.remove('text-white');
                link.classList.add('text-purple-600', 'hover:text-purple-600');
            });

            // Reset button and icon color
            loginButton.classList.remove('bg-pink-600', 'hover:bg-pink-700');
            loginButton.classList.add('bg-purple-600', 'hover:bg-purple-700');
            menuToggle.classList.remove('text-white');
            menuToggle.classList.add('text-purple-600');
        }
    });
</script>



  <!-- Hero Section -->
  <section class="relative min-h-screen bg-gradient-to-br  from-purple-600 via-purple-700 to-purple-800 overflow-hidden flex flex-col justify-center">
    <div class="absolute top-1/4 right-0 w-28 h-28 bg-yellow-400 rounded-full opacity-50"></div>
    <div class="absolute bottom-1/1 left-16 w-20 h-20 bg-yellow-300 rounded-full opacity-60"></div>
    <div class="absolute top-1/4 right-1/6 w-16 h-16 bg-orange-300 rounded-full opacity-50"></div>

    <div class="relative container max-w-4xl mx-auto px-4 text-center text-white space-y-8 mt-24">
        <h1 class="text-3xl md:text-6xl font-bold ">
            Manage your work, clients, and finances in one place
        </h1>

        <p class="text-white/80 text-lg md:text-xl max-w-2xl mx-auto">
            Ervop helps professionals automate works, manage clients & finances, schedule,
            and launch your complete business website in seconds.
        </p>

        <a href="#"   class="openModalBtn mt-10 inline-block bg-gradient-to-r from-pink-500 to-fuchsia-600 hover:bg-pink-600 text-white px-8 py-3 rounded-full font-semibold">
            Join Waitlist
        </a>

        <div style="margin-top: 90px;">
            <img src="{{asset('landingpage/image111.PNG')}}" alt="Business Team" class="w-full h-auto rounded-t-3xl shadow-2xl mx-auto" />
        </div>
    </div>
  </section>

    <section class="py-24  bg-white relative overflow-hidden">
        <div class="container mx-auto px-4 relative">

            <div class="text-center mb-20 max-w-5xl mx-auto">
                <!-- Label -->
                <p class="text-green-600 font-semibold uppercase mb-2 tracking-wide">
                    <span class="text-2xl  bg-gradient-to-r from-purple-600 via-pink-500 to-orange-400 bg-clip-text text-transparent italic">Stop Wasting Time</span>
                </p>

                <!-- Headline -->
                <h2 class="text-3xl md:text-4xl lg:text-6xl font-extrabold leading-tight tracking-tight mb-4">
                    Simplify, Automate, Grow.
                </h2>

                <!-- Supporting text -->
                <p class="text-lg text-muted-foreground max-w-2xl mx-auto leading-relaxed">
                    Ervop puts all your business operations on autopilot, so you focus on what really matters.
                </p>
            </div>


            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-10 max-w-8xl mx-auto">

            <!-- Feature Card -->
            <div class="group relative bg-card/60 border border-border/50 rounded-2xl p-6 backdrop-blur-md hover:border-primary/50 hover:shadow-xl transition-all duration-500 hover:-translate-y-2">
                <div class="overflow-hidden rounded-xl mb-5">
                <img src="{{asset('landingpage/ervop_abt.PNG')}}" alt="AI Website Builder" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
                </div>
                <h3 class="text-2xl font-bold mb-3 group-hover:text-primary transition-colors">Smart Business Website</h3>
                <p class="text-muted-foreground leading-relaxed">
                Create stunning professional websites in minutes with our AI-powered design engine. No coding required.
                </p>
            </div>



            <div class="group relative bg-card/60 border border-border/50 rounded-2xl p-6 backdrop-blur-md hover:border-primary/50 hover:shadow-xl transition-all duration-500 hover:-translate-y-2">
                <div class="overflow-hidden rounded-xl mb-5">
                <img src="{{asset('landingpage/appointmentPage.PNG')}}" alt="Smart Scheduling" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
                </div>
                <h3 class="text-2xl font-bold mb-3 group-hover:text-primary transition-colors">Smart Scheduling</h3>
                <p class="text-muted-foreground leading-relaxed">
                Intelligent appointment booking system that syncs with your calendar and availability.
                </p>
            </div>

             <div class="group relative bg-card/60 border border-border/50 rounded-2xl p-6 backdrop-blur-md hover:border-primary/50 hover:shadow-xl transition-all duration-500 hover:-translate-y-2">
                <div class="overflow-hidden rounded-xl mb-5">
                <img src="{{asset('landingpage/custsomForm.PNG')}}" alt="Custom Forms" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
                </div>
                <h3 class="text-2xl font-bold mb-3 group-hover:text-primary transition-colors">Smart Form Builder</h3>
                <p class="text-muted-foreground leading-relaxed">
                    Professional form builder that automatically organizes responses and integrates with your workflows.
                </p>
            </div>

            <div class="group relative bg-card/60 border border-border/50 rounded-2xl p-6 backdrop-blur-md hover:border-primary/50 hover:shadow-xl transition-all duration-500 hover:-translate-y-2">
                <div class="overflow-hidden rounded-xl mb-5">
                <img src="{{asset('landingpage/custsomForm.PNG')}}" alt="AI Task Generation" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
                </div>
                <h3 class="text-2xl font-bold mb-3 group-hover:text-primary transition-colors">Client Works Manager</h3>
                <p class="text-muted-foreground leading-relaxed">
                Let AI analyze your business needs and automatically generate optimized task workflows.
                </p>
            </div>



            <div class="group relative bg-card/60 border border-border/50 rounded-2xl p-6 backdrop-blur-md hover:border-primary/50 hover:shadow-xl transition-all duration-500 hover:-translate-y-2">
                <div class="overflow-hidden rounded-xl mb-5">
                <img src="{{asset('landingpage/docManager.PNG')}}" alt="Document Manager" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
                </div>
                <h3 class="text-2xl font-bold mb-3 group-hover:text-primary transition-colors">Document Manager</h3>
                <p class="text-muted-foreground leading-relaxed">
                Organize, store, and share all your business documents with advanced search capabilities.
                </p>
            </div>

            <div class="group relative bg-card/60 border border-border/50 rounded-2xl p-6 backdrop-blur-md hover:border-primary/50 hover:shadow-xl transition-all duration-500 hover:-translate-y-2">
                <div class="overflow-hidden rounded-xl mb-5">
                <img src="{{asset('landingpage/finance3.png')}}" alt="Expense Tracking" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
                </div>
                <h3 class="text-2xl font-bold mb-3 group-hover:text-primary transition-colors">Smart Finance Manager</h3>
                <p class="text-muted-foreground leading-relaxed">
                    Automate invoicing, manage payments, track expenses, and handle bills—all your business finances in one place.
                </p>

            </div>





            </div>
        </div>
    </section>


<section class="py-24  bg-gradient-to-br from-gray-50 to-white relative overflow-hidden">
  <div class="container mx-auto px-4 lg:px-4">



    <div class="grid lg:grid-cols-2 gap-16 items-center">

      <!-- Left: Image + Overlay Text -->
        <!-- Left: Fancy Section -->
        <div class="relative col-span-1 rounded-3xl overflow-hidden shadow-2xl flex flex-col justify-center h-full min-h-[700px] p-12"
            style="background: linear-gradient(135deg, #7F00FF 0%, #E100FF 50%, #FF7F50 100%);">

            <!-- Optional: animated gradient overlay for more flair -->
            <div class="absolute inset-0 bg-gradient-to-tr from-purple-700 via-pink-500 to-orange-400 opacity-70 mix-blend-multiply animate-gradient-background"></div>

            <!-- Text + CTA -->
            <div class="relative text-white max-w-md">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-4 leading-tight">
                Empowering Professionals with AI-Powered Tools
                </h2>
                <p class="text-white/90 text-lg mb-6">
                From solo professionals to growing teams — Ervop simplifies every part of your business workflow.
                </p>
                <a href="#get-started"
                class="inline-block bg-white/20 hover:bg-white/30 backdrop-blur-lg text-white px-6 py-3 rounded-xl font-semibold transition">
                Get Started
                </a>
            </div>
        </div>

        <!-- Tailwind Animations -->
        <style>
        @keyframes gradient-background {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient-background {
            background-size: 200% 200%;
            animation: gradient-background 12s ease infinite;
        }
        </style>

      <!-- Right: Target Audience Cards -->
      <div class="grid sm:grid-cols-2 gap-6">

        <!-- Card 1 -->
        <div class="p-6 border border-gray-200 rounded-2xl hover:shadow-xl hover:-translate-y-1 transition-all duration-300 bg-white/80 backdrop-blur">
          <div class="w-12 h-12 mb-4 flex items-center justify-center rounded-full bg-purple-100 text-purple-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v1a3 3 0 006 0v-1c0-1.657-1.343-3-3-3z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13a7 7 0 0114 0v5a2 2 0 01-2 2H7a2 2 0 01-2-2v-5z" />
            </svg>
          </div>
          <h4 class="text-lg font-semibold mb-1">Health & Wellness</h4>
          <p class="text-gray-600 text-md">For therapists, trainers, and nutritionists who manage client health goals and progress.</p>
        </div>

        <!-- Card 2 -->
        <div class="p-6 border border-gray-200 rounded-2xl hover:shadow-xl hover:-translate-y-1 transition-all duration-300 bg-white/80 backdrop-blur">
          <div class="w-12 h-12 mb-4 flex items-center justify-center rounded-full bg-pink-100 text-pink-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h4 class="text-lg font-semibold mb-1">Creative & Freelance</h4>
          <p class="text-gray-600 text-md">For freelancers, designers, and developers who handle clients and creative projects independently.</p>
        </div>

        <!-- Card 3 -->
        <div class="p-6 border border-gray-200 rounded-2xl hover:shadow-xl hover:-translate-y-1 transition-all duration-300 bg-white/80 backdrop-blur">
          <div class="w-12 h-12 mb-4 flex items-center justify-center rounded-full bg-purple-100 text-purple-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
            </svg>
          </div>
          <h4 class="text-lg font-semibold mb-1">Business & Startups</h4>
          <p class="text-gray-600 text-md">For startups, consultants, and legal or financial pros who onboard clients and manage operations.</p>
        </div>

        <!-- Card 4 -->
        <div class="p-6 border border-gray-200 rounded-2xl hover:shadow-xl hover:-translate-y-1 transition-all duration-300 bg-white/80 backdrop-blur">
          <div class="w-12 h-12 mb-4 flex items-center justify-center rounded-full bg-green-100 text-green-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2h6v2m0 4H9a2 2 0 01-2-2v-6a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2z" />
            </svg>
          </div>
          <h4 class="text-lg font-semibold mb-1">Home, Tech & Education</h4>
          <p class="text-gray-600 text-md">For contractors, tutors, architects, and tech consultants managing projects or student data.</p>
        </div>

      </div>
    </div>
  </div>
</section>


<section class="py-24 bg-gradient-to-br from-gray-50 to-white relative overflow-hidden">
  <div class="container mx-auto px-6 lg:px-12 grid lg:grid-cols-2 gap-16 items-center">

    <!-- Left: Text Content -->
    <div class="max-w-xl">
      <h2 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
        Give clients clarity with a <span class="bg-gradient-to-r from-purple-600 to-blue-500 bg-clip-text text-transparent">dedicated client portal</span>
      </h2>
      <p class="mt-5 text-lg text-gray-600">
          Give your clients a dedicated link where they can track real-time project updates, invoices, payments, share & access feedbacks, and secure documents.
        </p>

      <ul class="space-y-3 mt-10 text-gray-700">
        <li class="flex items-start gap-3">
          <span class="text-purple-600 mt-1">✔</span>
          <span>Track project progress and milestones effortlessly.</span>
        </li>
        <li class="flex items-start gap-3">
          <span class="text-purple-600 mt-1">✔</span>
          <span>View invoices, payments, and due dates in one place.</span>
        </li>
        <li class="flex items-start gap-3">
          <span class="text-purple-600 mt-1">✔</span>
          <span>Access shared files, notes, and feedback instantly.</span>
        </li>
      </ul>

      <div class="mt-10 flex gap-4">
        <a href="#" class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-full transition-all duration-300">
          Try for free
        </a>
        <a href="#" class="px-6 py-3 border border-gray-300 rounded-full text-gray-700 hover:bg-gray-100 font-medium transition-all duration-300">
          See how it works
        </a>
      </div>
    </div>

    <!-- Right: Image Mockup -->
    <div class="relative">
      <img src="{{asset('landingpage/11221.PNG')}}" alt="Client Portal Dashboard" class="rounded-3xl h-auto shadow-2xl w-full">
      <div class="absolute -bottom-8 -right-8 bg-white p-4 rounded-2xl shadow-lg w-64">
        <h4 class="text-gray-900 font-semibold mb-2 text-sm">Client Access View</h4>
        <p class="text-gray-600 text-sm leading-relaxed">Clients can check updates, download documents, and make payments anytime.</p>
      </div>
    </div>
  </div>
</section>

<section class="py-24 bg-gradient-to-b from-purple-50 to-gray-100">
  <div class="max-w-7xl mx-auto px-4">
    <!-- Heading -->
    <h2 class="text-3xl md:text-5xl font-bold mb-4 text-center text-gray-800">
      Simple, Transparent Pricing
    </h2>
    <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto text-center mb-10">
      Choose the perfect plan for your business. All plans include a 14-day free trial.
    </p>

    <!-- Billing Toggle -->
    <div class="mt-8 flex justify-center items-center space-x-2 mb-12">
      <span id="monthly-label" class="text-sm font-bold text-purple-600 cursor-pointer" onclick="setBilling('monthly')">Billed monthly</span>
      <label for="toggle-quarterly" class="inline-flex relative items-center cursor-pointer">
        <input type="checkbox" id="toggle-quarterly" class="sr-only peer" onchange="setBilling(this.checked ? 'quarterly' : 'monthly')">
        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
      </label>
      <span id="quarterly-label" class="text-sm font-medium text-gray-600 cursor-pointer" onclick="setBilling('quarterly')">Billed quarterly</span>
    </div>

    <style>
      .hide-scrollbar::-webkit-scrollbar { display: none; }
      .hide-scrollbar { scrollbar-width: none; -ms-overflow-style: none; }
    </style>

    <!-- Scrollable Pricing Table -->
    <div class="shadow-xl rounded-xl border border-gray-200 bg-white overflow-hidden relative">
      <div class="overflow-y-auto hide-scrollbar overflow-x-auto h-[520px] md:h-[600px]">
        <div class="min-w-[900px]">

          <!-- Header Row -->
          <div class="grid grid-cols-5 text-gray-800 font-semibold text-lg py-4 border-b border-gray-200 sticky top-0 z-20 bg-white">
            <div class="col-span-1 pl-6"></div>
            <div class="text-center">Free</div>
            <div class="text-center">Basic</div>
            <div class="text-center text-purple-700 relative">
              <span>Pro</span>
              <span class="absolute -top-5 left-1/2 -translate-x-1/2 bg-purple-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-md whitespace-nowrap">
                Recommended
              </span>
            </div>
            <div class="text-center">Business</div>
          </div>

          <!-- Pricing Row -->
          <div class="grid grid-cols-5 py-4 border-b border-gray-100 text-gray-800 items-center">
            <div class="col-span-1 pl-6 font-medium" id="billing-cycle-text">Price (Monthly)</div>
            <div class="text-center font-bold text-xl text-gray-900" data-price-tier="free">₦0</div>
            <div class="text-center font-bold text-xl text-gray-900" data-price-tier="basic">₦8,400</div>
            <div class="text-center font-bold text-xl text-purple-700" data-price-tier="pro">₦16,800</div>
            <div class="text-center font-bold text-xl text-gray-900" data-price-tier="business">₦28,000</div>
          </div>

          <!-- Ideal For -->
          <div class="grid grid-cols-5 py-4 border-b border-gray-100 text-gray-800 items-center">
            <div class="col-span-1 pl-6 font-medium">Ideal For</div>
            <div class="text-center">Freelancers & individuals</div>
            <div class="text-center">Solo professionals & consultants</div>
            <div class="text-center">Growing small teams</div>
            <div class="text-center">Agencies & enterprises</div>
          </div>

          <!-- Description -->
          <div class="grid grid-cols-5 py-4 border-b border-gray-100 text-gray-700 text-sm leading-relaxed items-center">
            <div class="col-span-1 pl-6 font-medium text-gray-800">Description</div>
            <div class="text-center px-3">Access to core tools with limits</div>
            <div class="text-center px-3">Add automations & invoicing</div>
            <div class="text-center px-3">Unlock projects & AI tools</div>
            <div class="text-center px-3">Full suite with branding & integrations</div>
          </div>

          <!-- Features -->
          <div id="features-container" class="divide-y divide-gray-100"></div>

          <!-- Buttons -->
          <div class="grid grid-cols-5 py-6 border-t border-gray-200 bg-white sticky bottom-0 z-30 min-w-[900px] px-2 sm:px-4">
            <div class="col-span-1"></div>

            <div class="text-center">
              <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded-lg transition text-sm sm:text-base">
                Get Started
              </button>
            </div>

            <div class="text-center">
              <button class="bg-purple-100 hover:bg-purple-200 text-purple-700 font-semibold px-4 py-2 rounded-lg transition text-sm sm:text-base">
                Get Started
              </button>
            </div>

            <div class="text-center">
              <button class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 py-2 rounded-lg transition shadow-md text-sm sm:text-base">
                Get Started
              </button>
            </div>

            <div class="text-center">
              <button class="bg-gray-800 hover:bg-black text-white font-semibold px-4 py-2 rounded-lg transition text-sm sm:text-base">
                Contact Sales
              </button>
            </div>
          </div>

        </div>
      </div>
    </div>

    <p class="text-center mt-12 text-gray-500">
      All plans include SSL security, daily backups, and 99.9% uptime guarantee.
    </p>
  </div>
</section>

<script>
  let userRegion = 'NG'; // Default region
  let userCurrency = 'NGN';
  let currencySymbol = '₦';

  // Price data for each region
  const priceData = {
    NG: {
      monthly: { free: 0, basic: 8400, pro: 16800, business: 28000 },
      quarterly: { free: 0, basic: 21600, pro: 43200, business: 72000 }
    },
    US: {
      monthly: { free: 0, basic: 8, pro: 16, business: 28 },
      quarterly: { free: 0, basic: 21, pro: 43, business: 72 }
    }
  };

  const features = [
    ["Users Included", "1", "2", "3", "10+"],
    ["Storage", "2 GB", "10 GB", "50 GB", "200 GB"],
    ["Projects Management", "1 Project", "5 Projects", "Unlimited", "Unlimited + Team Assignment"],
    ["Client CRM", "3 Clients", "20 Clients", "Unlimited", "Unlimited + Role Access"],
    ["Custom Form Builder", "—", "Basic", "Advanced (AI fields)", "Advanced + Automation"],
    ["Document Manager (Secure Sharing)", "100MB", "1GB", "10GB", "50GB + Team Access"],
    ["AI Website Builder", "—", "Basic Templates", "Full AI Builder", "White-label Builder"],
    ["Appointment Booking Tool", "—", "Manual Booking", "Smart Scheduling", "Scheduling + Client Portals"],
    ["Client Portal", "—", "—", "Customizable", "Branded + Custom Domain"],
    ["Invoices & Payments", "—", "Manual Invoices", "Automated + Links", "Multi-currency + Analytics"],
    ["Expenses & Bookkeeping", "—", "Manual", "Smart Categorization", "Team Finance + Reports"],
    ["AI Assistants", "—", "Limited", "Full", "Full + Integrations"],
    ["Team Collaboration", "—", "—", "Up to 5 Members", "Unlimited Teams"],
    ["Custom Branding", "—", "—", "Logo & Colors", "White-label Branding"],
    ["Integrations", "—", "—", "Google, Paystack", "Advanced APIs"],
    ["Analytics & Reports", "—", "Basic", "Detailed", "Advanced + Export"],
    ["Priority Support", "Community", "Email", "Chat + Email", "Dedicated Manager"],
  ];

  function renderFeatures() {
    const container = document.getElementById('features-container');
    features.forEach((row, i) => {
      const div = document.createElement('div');
      div.className = `grid grid-cols-5 py-4 ${i % 2 ? 'bg-gray-50' : ''} items-center text-gray-800`;
      div.innerHTML = `
        <div class="col-span-1 pl-6 font-medium">${row[0]}</div>
        <div class="text-center">${row[1]}</div>
        <div class="text-center">${row[2]}</div>
        <div class="text-center font-medium text-gray-900">${row[3]}</div>
        <div class="text-center">${row[4]}</div>`;
      container.appendChild(div);
    });
  }

  function setBilling(cycle) {
    const billingText = document.getElementById('billing-cycle-text');
    const toggle = document.getElementById('toggle-quarterly');
    const monthlyLabel = document.getElementById('monthly-label');
    const quarterlyLabel = document.getElementById('quarterly-label');
    const priceElements = document.querySelectorAll('[data-price-tier]');

    const regionKey = userRegion === 'NG' ? 'NG' : 'US';
    const data = priceData[regionKey][cycle];
    const symbol = regionKey === 'NG' ? '₦' : '$';

    billingText.textContent = `Price (${cycle.charAt(0).toUpperCase() + cycle.slice(1)})`;
    monthlyLabel.classList.toggle('text-purple-600', cycle === 'monthly');
    quarterlyLabel.classList.toggle('text-purple-600', cycle === 'quarterly');

    priceElements.forEach(el => {
      const tier = el.getAttribute('data-price-tier');
      const value = data[tier];
      const formatted = regionKey === 'NG'
        ? new Intl.NumberFormat('en-NG', { style: 'currency', currency: 'NGN', minimumFractionDigits: 0 }).format(value)
        : `${symbol}${value}`;
      el.textContent = formatted;
    });
  }

  async function detectRegion() {
    try {
      const response = await fetch('https://ipapi.co/json/');
      const data = await response.json();
      userRegion = data.country_code;
      userCurrency = data.currency;
      currencySymbol = userCurrency === 'NGN' ? '₦' : '$';
    } catch {
      userRegion = 'NG'; // fallback
    }
    setBilling('monthly');
  }

  document.addEventListener('DOMContentLoaded', () => {
    renderFeatures();
    detectRegion();
  });
</script>










<section class="py-16 px-4 md:px-8 lg:px-16 bg-white">
  <div class="max-w-7xl mx-auto">
    <div class="max-w-7xl mx-auto px-4 text-center">
    <h2 class="text-4xl lg:text-5xl font-bold mb-4">Frequently Asked Questions</h2>
    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
      Quick answers to questions you may have.
    </p>
  </div>

    <div class="grid mt-12 grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">

      <!-- FAQ Item 1 -->
      <details class="group border-b border-gray-200 py-4 cursor-pointer">
        <summary class="flex items-center space-x-4 justify-between font-semibold text-lg text-gray-900 list-none">
          <div class="flex items-center space-x-4">
            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center
                        bg-white border border-gray-200 rounded-lg text-gray-500 text-lg">
              <!-- Replaced Font Awesome with SVG -->
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
              </svg>
            </div>
            <h3>Is there a free trial available?</h3>
          </div>

          <!-- Chevron icon for dropdown -->
          <span class="text-gray-500 transition-transform duration-300 group-open:rotate-180">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>
          </span>
        </summary>

        <p class="mt-2 pl-14 text-base text-gray-700 pb-2">
          Yes, you can try us free for 30 days. If you want, we'll provide you with a free 30-minute onboarding call to get you up and running.
        </p>
      </details>

      <!-- FAQ Item 2 -->
      <details class="group border-b border-gray-200 py-4 cursor-pointer">
        <summary class="flex items-center space-x-4 justify-between font-semibold text-lg text-gray-900 list-none">
          <div class="flex items-center space-x-4">
            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center
                        bg-white border border-gray-200 rounded-lg text-gray-500 text-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <h3>Can I change my plan later?</h3>
          </div>

          <span class="text-gray-500 transition-transform duration-300 group-open:rotate-180">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>
          </span>
        </summary>

        <p class="mt-2 pl-14 text-base text-gray-700 pb-2">
          Of course you can! Our pricing scales with your company. Chat to our friendly team to find a solution that works for you as you grow.
        </p>
      </details>

      <!-- FAQ Item 3 -->
      <details class="group border-b border-gray-200 py-4 cursor-pointer">
        <summary class="flex items-center space-x-4 justify-between font-semibold text-lg text-gray-900 list-none">
          <div class="flex items-center space-x-4">
            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center
                        bg-white border border-gray-200 rounded-lg text-gray-500 text-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M18.364 5.636L5.636 18.364M5.636 5.636l12.728 12.728" />
              </svg>
            </div>
            <h3>What is your cancellation policy?</h3>
          </div>

          <span class="text-gray-500 transition-transform duration-300 group-open:rotate-180">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>
          </span>
        </summary>

        <p class="mt-2 pl-14 text-base text-gray-700 pb-2">
          We understand that things change. You can cancel your plan at any time and we'll refund you the difference already paid.
        </p>
      </details>

    </div>
  </div>
</section>




  <!-- Footer -->
  <footer class="bg-gray-50 border-t border-gray-200">
    <div class="container mx-auto px-4 py-16">
      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
        <div>
          <h3 class="text-2xl font-bold bg-gradient-to-r from-purple-500 to-pink-500 bg-clip-text text-transparent">
            Ervop AI
          </h3>
          <p class="text-gray-600 mt-3">
            The complete enterprise platform that automates your business workflow with AI-powered tools.
          </p>
          <div class="mt-4 text-sm text-gray-600 space-y-2">
            <div>📧 contact@ervop.com</div>
            <div>📍 Lagos Nigeria</div>
          </div>
        </div>

        <div>
          <h4 class="font-semibold text-gray-800 mb-3">Products</h4>
          <ul class="space-y-2 text-sm text-gray-600">
            <li>AI-Powered Website</li>
            <li>Smart Scheduling</li>
            <li>Smart Form Builder</li>
            <li>Client Works Manager</li>
            <li>Document Manager</li>
            <li>Smart Finance Manager</li>
            <li>Client Portal</li>
          </ul>
        </div>

        <div>
          <h4 class="font-semibold text-gray-800 mb-3">Company</h4>
          <ul class="space-y-2 text-sm text-gray-600">
            <li>About Us</li>
            <li>Pricing</li>
            <li>FAQ</li>
            <li>Blog</li>
            <li>Partners</li>
          </ul>
        </div>

        <div>
          <h4 class="font-semibold text-gray-800 mb-3">Stay Updated</h4>
          <p class="text-sm text-gray-600 mb-3">Get the latest updates and insights delivered to your inbox.</p>
          <form id="newsletterForm" class="space-y-2">
            <input
              id="newsletterEmail"
              type="email"
              placeholder="Your email"
              required
              class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
            />
            <button
              type="submit"
              class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-md text-sm font-semibold w-full"
            >
              Subscribe →
            </button>
          </form>
        </div>
      </div>

      <div class="border-t border-gray-200 pt-8 text-sm text-gray-500 flex flex-col md:flex-row justify-between">
        <div>© 2025 Ervop AI. All rights reserved.</div>
        <!-- <div class="flex gap-4 mt-2 md:mt-0">
          <a href="#" class="hover:text-gray-800">Privacy Policy</a>
          <a href="#" class="hover:text-gray-800">Terms of Service</a>
          <a href="#" class="hover:text-gray-800">Cookie Policy</a>
        </div> -->
      </div>
    </div>
  </footer>

   <div class="modalOverlay hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

    <!-- Modal Content -->
    <div class="bg-white rounded-3xl shadow-2xl p-8 w-[380px] text-center relative animate-fadeIn">

      <!-- Close Icon -->
      <button  class="closeModalBtn absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl font-bold">
        &times;
      </button>

      <!-- Header Text -->
      <h2 class="text-2xl font-bold text-gray-900 mb-2">
        Join Our Journey and <br> get early access
      </h2>

      <!-- Subtext -->
      <p class="text-gray-500 text-sm mb-6">
        No More Chaos. No More Guesswork. Just Growth
      </p>

      <!-- Avatars -->
      <div class="flex justify-center mb-6">
         <img src="{{asset('landingpage/waitlistpics.PNG')}}" class=" h-8 rounded-full border-2 border-white -mr-2" alt="">

      </div>

      <!-- Email Input -->
      <div class="mb-6">
        <input
          type="email"
          placeholder="Enter your email address here"
          class="w-full px-4 py-3 rounded-full border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-400"
        />
      </div>

      <!-- Submit Button -->
      <button class="w-full bg-gradient-to-r from-pink-500 to-fuchsia-600 text-white font-semibold py-3 rounded-full shadow-lg hover:opacity-90 transition">
        Submit
      </button>
    </div>
  </div>

  <!-- Optional Animations -->
  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }
    .animate-fadeIn {
      animation: fadeIn 0.3s ease-out;
    }
  </style>

  <!-- Modal Script -->
  <script>
   const openModalBtns = document.querySelectorAll('.openModalBtn');
const closeModalBtns = document.querySelectorAll('.closeModalBtn');
const modalOverlays = document.querySelectorAll('.modalOverlay');

openModalBtns.forEach((btn) => {
  btn.addEventListener('click', (e) => {
    e.preventDefault();
    const targetModal = btn.closest('body').querySelector('.modalOverlay');
    targetModal.classList.remove('hidden');
  });
});

closeModalBtns.forEach((btn) => {
  btn.addEventListener('click', () => {
    btn.closest('.modalOverlay').classList.add('hidden');
  });
});

    // Close when clicking outside the modal
    modalOverlay.addEventListener('click', (e) => {
      if (e.target === modalOverlay) {
        modalOverlay.classList.add('hidden');
      }
    });
  </script>


  <script>
    // Waitlist form
    document.getElementById("waitlistForm").addEventListener("submit", function(e) {
      e.preventDefault();
      const email = document.getElementById("emailInput").value;
      console.log("Waitlist signup:", email);
      alert("Thanks for joining the waitlist, " + email + "!");
      e.target.reset();
    });

    // Newsletter form
    document.getElementById("newsletterForm").addEventListener("submit", function(e) {
      e.preventDefault();
      const email = document.getElementById("newsletterEmail").value;
      console.log("Newsletter signup:", email);
      alert("You're subscribed! " + email);
      e.target.reset();
    });
  </script>
</body>
</html>
