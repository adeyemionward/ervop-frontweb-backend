<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adeyemi's Designs - Handcrafted Fashion</title>
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
        /* Styles for sliders */
        .slider-container {
            overflow: hidden;
        }
        .slider-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        .slide {
            min-width: 100%;
            box-sizing: border-box;
        }
        .group:hover .add-to-cart {
            transform: translateY(0);
            opacity: 1;
        }
        /* Styles for the new hero carousel */
        .hero-slider-track {
            display: flex;
            transition: transform 0.7s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .hero-slide {
            min-width: 100%;
            box-sizing: border-box;
            position: relative;
        }
        .hero-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .pagination-dot.active {
            background-color: white;
            transform: scale(1.2);
        }

        /* APPINTMENT STYLE */
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
        }
        .day-active {
            background-color: #2563eb !important; /* bg-blue-600 */
            color: white !important;
            font-weight: bold;
        }
        .service-active, .time-slot-active {
             background-color: #eff6ff !important; /* bg-blue-50 */
             border-color: #2563eb !important; /* border-blue-600 */
        }
        .service-active p {
            color: #1e40af; /* text-blue-800 */
        }
        /* END APPOINTMENT STYLE */

        /* FAQ */
            .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
        }
        .faq-question.active + .faq-answer {
            max-height: 200px; /* Adjust as needed */
        }
        .faq-question.active .icon-plus {
            transform: rotate(45deg);
        }
        /* END FAQ */

        /* services */
        /* Dashed line for the process section */
        .process-step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 4rem; /* Adjust based on icon circle size */
            left: 50%;
            transform: translateX(-50%);
            height: calc(100% - 4rem);
            border-left: 2px dashed #cbd5e1; /* border-gray-300 */
        }
        @media (min-width: 768px) {
            .process-step:not(:last-child)::after {
                top: 2.5rem;
                left: calc(50% + 2.5rem);
                width: calc(100% - 5rem);
                height: 2px;
                border-left: none;
                border-top: 2px dashed #cbd5e1;
            }
        }
        /* end services */
    </style>
</head>
<body class="bg-white text-gray-800">

  

    <!-- Main Content -->
     <main>
        @yield('content')
    </main>

    <!-- Footer -->
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

        // Mobile Menu Logic
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Hero Carousel Logic
        const heroTrack = document.querySelector('.hero-slider-track');
        if (heroTrack) {
            const heroSlides = Array.from(heroTrack.children);
            const heroNextButton = document.getElementById('heroNextBtn');
            const heroPrevButton = document.getElementById('heroPrevBtn');
            const heroPagination = document.getElementById('heroPagination');

            if(heroSlides.length > 0) {
                const slideWidth = heroSlides[0].getBoundingClientRect().width;
                let currentIndex = 0;

                // Create pagination dots
                heroSlides.forEach((slide, index) => {
                    const dot = document.createElement('button');
                    dot.classList.add('pagination-dot', 'w-3', 'h-3', 'bg-white/50', 'rounded-full', 'transition-all', 'duration-300');
                    if (index === 0) dot.classList.add('active');
                    dot.addEventListener('click', () => moveToHeroSlide(index));
                    heroPagination.appendChild(dot);
                });
                const dots = Array.from(heroPagination.children);

                const updateDots = (targetIndex) => {
                    dots.forEach((dot, index) => {
                        dot.classList.toggle('active', index === targetIndex);
                    });
                };

                const moveToHeroSlide = (targetIndex) => {
                    heroTrack.style.transform = 'translateX(-' + slideWidth * targetIndex + 'px)';
                    currentIndex = targetIndex;
                    updateDots(currentIndex);
                }

                heroNextButton.addEventListener('click', () => {
                    const nextIndex = (currentIndex + 1) % heroSlides.length;
                    moveToHeroSlide(nextIndex);
                });

                heroPrevButton.addEventListener('click', () => {
                    let prevIndex = currentIndex - 1;
                    if (prevIndex < 0) prevIndex = heroSlides.length - 1;
                    moveToHeroSlide(prevIndex);
                });

                setInterval(() => {
                    const nextIndex = (currentIndex + 1) % heroSlides.length;
                    moveToHeroSlide(nextIndex);
                }, 7000); // Auto-slide every 7 seconds
            }
        }


        // Testimonial Slider Logic
        const track = document.querySelector('.slider-track');
        if (track) {
            const slides = Array.from(track.children);
            const nextButton = document.getElementById('nextBtn');
            const prevButton = document.getElementById('prevBtn');

            if(slides.length > 0) {
                const slideWidth = slides[0].getBoundingClientRect().width;
                let currentIndex = 0;

                const moveToSlide = (targetIndex) => {
                    if(track) {
                       track.style.transform = 'translateX(-' + slideWidth * targetIndex + 'px)';
                    }
                    currentIndex = targetIndex;
                }

                nextButton.addEventListener('click', e => {
                    const nextIndex = (currentIndex + 1) % slides.length;
                    moveToSlide(nextIndex);
                });

                prevButton.addEventListener('click', e => {
                    let prevIndex = currentIndex - 1;
                    if (prevIndex < 0) {
                        prevIndex = slides.length - 1;
                    }
                    moveToSlide(prevIndex);
                });

                setInterval(() => {
                    const nextIndex = (currentIndex + 1) % slides.length;
                    moveToSlide(nextIndex);
                }, 5000);
            }
        }
    </script>
    {{-- appintment js --}}
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
                    button.className = 'time-slot-btn py-2 border border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors';
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
                serviceOptions.forEach(opt => opt.classList.remove('service-active', 'border-blue-500', 'bg-blue-50'));
                option.classList.add('service-active', 'border-blue-500', 'bg-blue-50');
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
    {{-- end appointment js --}}

    {{-- start FAQ --}}
        <script>
        lucide.createIcons();

        // FAQ Accordion Logic
        const faqQuestions = document.querySelectorAll('.faq-question');
        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                // Close other open questions
                faqQuestions.forEach(otherQuestion => {
                    if (otherQuestion !== question) {
                        otherQuestion.classList.remove('active');
                    }
                });
                // Toggle the clicked question
                question.classList.toggle('active');
            });
        });
    </script>
    {{-- END FAQ --}}
     @yield('scripts')
</body>
</html>

