<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Consultation - Aisha Bello</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom Icons for a more polished look -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        html {
            scroll-behavior: smooth;
        }
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
        }
        .day-active {
            background-color: #9a52f8 !important; /* bg-purple-600 */
            color: white !important;
            font-weight: bold;
        }
        .service-active, .time-slot-active {
             background-color: #eff6ff !important; /* bg-purple-50 */
             border-color: #9a52f8 !important; /* border-purple-600 */
        }
        .service-active p {
            color: #9a52f8; /* text-purple-800 */
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Header -->
    <header class="sticky top-0 bg-white/90 backdrop-blur-md z-50 border-b border-gray-200">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Aisha Bello</h1>
            <nav class="hidden md:flex items-center space-x-8">
                <a href="#" class="text-gray-600 hover:text-purple-600 font-medium transition-colors">Home</a>
                <a href="#" class="text-gray-600 hover:text-purple-600 font-medium transition-colors">Shop</a>
                <a href="#" class="text-gray-600 hover:text-purple-600 font-medium transition-colors">Services</a>
            </nav>
            <a href="#" class="bg-purple-600 text-white hover:bg-purple-700 font-semibold py-2 px-5 rounded-lg transition-colors hidden md:flex">
                Book a Consultation
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-12 md:py-20">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight">
                    Schedule Your Appointment
                </h1>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                    Let's connect. Choose a service and select a time that works best for you.
                </p>
            </div>

            <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-lg">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    <!-- Left Column: Service Selection -->
                    <div class="md:col-span-1 border-b md:border-b-0 md:border-r border-gray-200 pb-8 md:pb-0 md:pr-8">
                        <h2 class="text-xl font-bold text-gray-900">1. Select Purpose</h2>
                        <div class="mt-6 space-y-4">
                            <div id="service-free" class="service-option p-4 border-2 border-purple-500 bg-purple-50 rounded-lg cursor-pointer service-active">
                                <p class="font-semibold text-purple-800">Free Discovery Call</p>
                                <p class="text-sm text-purple-700 mt-1">1 hour</p>
                            </div>
                            <div id="service-paid" class="service-option p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-purple-500">
                                <p class="font-semibold text-gray-800">Follow-up Meeting</p>
                                <p class="text-sm text-gray-600 mt-1">1 hour</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Calendar & Time -->
                    <div class="md:col-span-2">
                        <h2 class="text-xl font-bold text-gray-900">2. Choose a Date & Time</h2>

                        <!-- Interactive Calendar -->
                        <div class="mt-6">
                            <div class="flex justify-between items-center">
                                <button id="prev-month-btn" class="p-2 rounded-full hover:bg-gray-100"><i data-lucide="chevron-left" class="w-5 h-5 text-gray-600"></i></button>
                                <h3 id="month-year-title" class="text-lg font-semibold text-gray-900">July 2025</h3>
                                <button id="next-month-btn" class="p-2 rounded-full hover:bg-gray-100"><i data-lucide="chevron-right" class="w-5 h-5 text-gray-600"></i></button>
                            </div>
                            <div class="calendar-grid text-center text-sm mt-4">
                                <div class="font-semibold text-gray-500 py-2">Sun</div><div class="font-semibold text-gray-500 py-2">Mon</div><div class="font-semibold text-gray-500 py-2">Tue</div><div class="font-semibold text-gray-500 py-2">Wed</div><div class="font-semibold text-gray-500 py-2">Thu</div><div class="font-semibold text-gray-500 py-2">Fri</div><div class="font-semibold text-gray-500 py-2">Sat</div>
                                <!-- Calendar days will be generated by JS -->
                            </div>
                        </div>

                        <!-- Time Slot Picker -->
                        <div id="time-slot-section" class="mt-6">
                            <h3 class="font-semibold text-gray-800">Available Times for <span id="selected-date-text" class="text-purple-600">July 29, 2025</span></h3>
                            <div id="time-slots" class="mt-4 grid grid-cols-3 sm:grid-cols-4 gap-3">
                                <!-- Time slots will be generated by JS -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Final Step: Details Form -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">3. Enter Your Details</h2>

                    <!-- Booking Summary -->
                    <div id="booking-summary" class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200 text-sm">
                        <!-- Summary will be generated by JS -->
                    </div>

                    <form class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" id="name" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" id="email" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        </div>
                        <div class="md:col-span-2">
                             <label for="details" class="block text-sm font-medium text-gray-700">Please provide a brief description of your needs</label>
                             <textarea id="details" rows="4" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm"></textarea>
                        </div>
                    </form>
                </div>

                <!-- Confirmation Button -->
                <div class="mt-8 flex justify-end">
                    <button class="bg-purple-600 text-white hover:bg-purple-700 font-semibold py-3 px-8 rounded-lg text-lg transition-colors shadow-lg hover:shadow-xl">
                        Confirm Booking
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-20">
        <div class="container mx-auto px-6 py-12 text-center">
             <div class="mt-12 border-t border-gray-700 pt-8 text-sm text-gray-400">
                <p>&copy; 2025 Aisha Bello. Powered by Ervop.</p>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();

        // --- JavaScript for Interactive Booking ---

        // State variables
        let selectedService = 'Free Discovery Call';
        let currentDate = new Date(2025, 6, 1); // July 2025 (month is 0-indexed)
        let selectedDate = new Date(2025, 6, 29);
        let selectedTime = null;

        // Mock data for available time slots
        const availableSlots = {
            "2025-07-29": ["09:00 AM", "10:00 AM", "02:00 PM", "03:00 PM"],
            "2025-07-30": ["11:00 AM", "12:00 PM", "04:00 PM"],
            "2025-07-31": ["09:30 AM", "10:30 AM"],
            "2025-08-01": ["10:00 AM", "11:00 AM", "01:00 PM"]
        };

        // DOM Elements
        const serviceOptions = document.querySelectorAll('.service-option');
        const timeSlotsContainer = document.getElementById('time-slots');
        const selectedDateText = document.getElementById('selected-date-text');
        const bookingSummary = document.getElementById('booking-summary');
        const monthYearTitle = document.getElementById('month-year-title');
        const prevMonthBtn = document.getElementById('prev-month-btn');
        const nextMonthBtn = document.getElementById('next-month-btn');
        const calendarGrid = document.querySelector('.calendar-grid');

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            monthYearTitle.textContent = currentDate.toLocaleString('default', { month: 'long', year: 'numeric' });

            const firstDayOfMonth = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            // Clear existing calendar days
            const existingDays = calendarGrid.querySelectorAll('.calendar-day, .empty-day');
            existingDays.forEach(day => day.remove());

            // Add empty cells for the start of the month
            for (let i = 0; i < firstDayOfMonth; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.className = 'empty-day h-10';
                calendarGrid.appendChild(emptyCell);
            }

            // Add days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayCell = document.createElement('div');
                dayCell.className = 'py-2 h-10 flex items-center justify-center calendar-day cursor-pointer rounded-full';
                dayCell.textContent = day;
                dayCell.dataset.date = day;

                const fullDate = new Date(year, month, day);
                if (fullDate.toDateString() === selectedDate.toDateString()) {
                    dayCell.classList.add('day-active');
                }

                dayCell.addEventListener('click', () => {
                    selectedDate = new Date(year, month, day);
                    renderCalendar(); // Re-render to show active state
                    updateAvailableTimes();
                });
                calendarGrid.appendChild(dayCell);
            }
        }

        function updateBookingSummary() {
            const dateString = selectedDate.toLocaleDateString('default', { month: 'long', day: 'numeric', year: 'numeric' });
            if (selectedService && selectedDate && selectedTime) {
                bookingSummary.innerHTML = `
                    <p><span class="font-semibold">Service:</span> ${selectedService}</p>
                    <p><span class="font-semibold">Date:</span> ${dateString}</p>
                    <p><span class="font-semibold">Time:</span> ${selectedTime}</p>
                `;
            } else {
                bookingSummary.innerHTML = '<p class="text-gray-500">Please select a service, date, and time.</p>';
            }
        }

        function updateAvailableTimes() {
            const dateKey = `${selectedDate.getFullYear()}-${String(selectedDate.getMonth() + 1).padStart(2, '0')}-${String(selectedDate.getDate()).padStart(2, '0')}`;
            selectedTime = null; // Reset time when date changes
            selectedDateText.textContent = selectedDate.toLocaleDateString('default', { month: 'long', day: 'numeric', year: 'numeric' });
            timeSlotsContainer.innerHTML = '';
            const slots = availableSlots[dateKey] || [];

            if (slots.length === 0) {
                timeSlotsContainer.innerHTML = '<p class="text-gray-500 col-span-full">No available times for this date.</p>';
            } else {
                slots.forEach(time => {
                    const button = document.createElement('button');
                    button.className = 'time-slot-btn py-2 border border-gray-300 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-colors';
                    button.textContent = time;

                    button.addEventListener('click', () => {
                        document.querySelectorAll('.time-slot-btn').forEach(btn => btn.classList.remove('time-slot-active'));
                        button.classList.add('time-slot-active');
                        selectedTime = time;
                        updateBookingSummary();
                    });
                    timeSlotsContainer.appendChild(button);
                });
            }
            updateBookingSummary();
        }

        // Service Selection Logic
        serviceOptions.forEach(option => {
            option.addEventListener('click', () => {
                serviceOptions.forEach(opt => opt.classList.remove('service-active', 'border-purple-500', 'bg-purple-50'));
                option.classList.add('service-active', 'border-purple-500', 'bg-purple-50');
                selectedService = option.querySelector('p').textContent;
                updateBookingSummary();
            });
        });

        // Month Navigation Logic
        prevMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });
        nextMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });

        // Initial setup
        renderCalendar();
        updateAvailableTimes();

    </script>
</body>
</html>
