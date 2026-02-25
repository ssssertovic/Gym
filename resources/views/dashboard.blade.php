<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Početna') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Hero Section: text left, image right on desktop; stacked on mobile. Place fitness.jpg in public/images/ for the hero image. --}}
            <div class="bg-gradient-to-r from-purple-500 to-purple-700 rounded-2xl shadow-xl mb-8 overflow-hidden">
                <div class="p-6 md:p-8 lg:p-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 lg:gap-10">
                    <div class="flex-1 text-white order-2 lg:order-1">
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 leading-tight">
                            Transformiši svoje tijelo. Ojačaj svoj um. Počni danas.
                        </h1>
                        <p class="text-lg sm:text-xl opacity-95 mb-4">
                            Tvoj put ka zdravijem, snažnijem i samopouzdanijem životu počinje ovdje. Postavi ciljeve, treniraj uz profesionalce i ostvari rezultate na koje ćeš biti ponosna.
                        </p>
                        <p class="text-base sm:text-lg font-medium mb-6 opacity-90">
                            Ne čekaj savršen trenutak. Stvori ga.
                        </p>
                        <a href="{{ route('plans') }}" class="inline-block bg-white text-purple-700 font-bold px-6 py-3 rounded-xl shadow-lg hover:bg-purple-50 transition-colors">
                            Započni danas
                        </a>
                    </div>
                    <div class="flex-shrink-0 order-1 lg:order-2 w-full lg:w-96">
                        {{-- Image: place fitness.jpg in public/images/ --}}
                        <img src="{{ asset('images/fitness.jpg') }}" alt="Fitness" class="w-full h-56 sm:h-64 lg:h-80 object-cover rounded-xl shadow-lg"
                             onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22300%22 viewBox=%220 0 400 300%22%3E%3Crect fill=%22%236b21a8%22 width=%22400%22 height=%22300%22/%3E%3Ctext fill=%22%23fff%22 font-family=%22sans-serif%22 font-size=%2218%22 x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22%3EStavi fitness.jpg u public/images/%3C/text%3E%3C/svg%3E';">
                    </div>
                </div>
            </div>

            {{-- Dnevna motivacija: quote from external API, refreshes every 30s --}}
            <section class="mb-8 bg-white rounded-xl shadow-md border border-purple-100 overflow-hidden">
                <h2 class="text-xl font-bold text-purple-800 pt-6 px-6 pb-2 text-center">Dnevna motivacija</h2>
                <div class="p-6 pt-2 min-h-[120px] flex flex-col justify-center">
                    <p id="quote-loading" class="text-center text-gray-500 italic">Učitavanje citata...</p>
                    <div id="quote-content" class="hidden">
                        <p id="quote-text" class="text-xl sm:text-2xl text-purple-900 italic text-center quote-fade transition-opacity duration-500"></p>
                        <p id="quote-author" class="text-sm sm:text-base text-purple-600 text-center mt-3"></p>
                    </div>
                </div>
            </section>

            {{-- Zašto Astra Fit? --}}
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Zašto Astra Fit?</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow border border-purple-100">
                        <div class="flex-shrink-0 bg-purple-100 rounded-full p-3 w-12 h-12 flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-1">Profesionalni treneri</h3>
                        <p class="text-sm text-gray-600">Treniraj uz stručno vodstvo i podršku.</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow border border-purple-100">
                        <div class="flex-shrink-0 bg-purple-100 rounded-full p-3 w-12 h-12 flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-1">Fleksibilni planovi</h3>
                        <p class="text-sm text-gray-600">Odaberi članstvo koje ti najbolje odgovara.</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow border border-purple-100">
                        <div class="flex-shrink-0 bg-purple-100 rounded-full p-3 w-12 h-12 flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-1">Moderan prostor</h3>
                        <p class="text-sm text-gray-600">Ugodno okruženje i kvalitetna oprema.</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow border border-purple-100">
                        <div class="flex-shrink-0 bg-purple-100 rounded-full p-3 w-12 h-12 flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-1">Rezervacije termina</h3>
                        <p class="text-sm text-gray-600">Jednostavno zakaži trening u željeno vrijeme.</p>
                    </div>
                </div>
            </section>

            @if(auth()->user()->role === 'admin' && isset($stats))
            {{-- Stats Cards - Admin only (below hero and features) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20H2v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Broj članova</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['members_count'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Broj planova</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['plans_count'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Broj trenera</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['trainers_count'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Broj treninga</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['workouts_count'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Brzi pristup --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Brzi pristup</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('plans') }}" class="p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors text-center">
                        <p class="font-semibold text-purple-700">Planovi</p>
                    </a>
                    <a href="{{ route('trainers') }}" class="p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors text-center">
                        <p class="font-semibold text-purple-700">Treneri</p>
                    </a>
                    <a href="{{ route('bookings.index') }}" class="p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors text-center">
                        <p class="font-semibold text-purple-700">{{ auth()->user()->role === 'admin' ? 'Sve rezervacije' : 'Moje rezervacije' }}</p>
                    </a>
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('members') }}" class="p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors text-center">
                        <p class="font-semibold text-purple-700">Članovi</p>
                    </a>
                    <a href="{{ route('workouts') }}" class="p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors text-center">
                        <p class="font-semibold text-purple-700">Treninzi</p>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Motivational quote: fetch from API, refresh every 30s, fallback on error --}}
    <style>
        .quote-fade { opacity: 1; }
        .quote-fade.quote-updating { opacity: 0; transition: opacity 0.3s ease-out; }
        .quote-fade.quote-visible { opacity: 1; transition: opacity 0.5s ease-in; }
    </style>
    <script>
        (function () {
            // Local proxy returns { "text": "...", "author": "..." }
            var QUOTE_API = '/quote';
            // Fallback when proxy fails (network error or non-200)
            var FALLBACK_QUOTE = 'Snaga dolazi iz upornosti. Nastavi dalje.';
            var FALLBACK_AUTHOR = 'Astra Fit';
            var REFRESH_INTERVAL_MS = 30000; // 30 seconds

            var quoteTextEl = document.getElementById('quote-text');
            var quoteAuthorEl = document.getElementById('quote-author');
            var quoteContentEl = document.getElementById('quote-content');
            var quoteLoadingEl = document.getElementById('quote-loading');

            var lastQuoteText = '';

            /** Builds quote URL with cache-buster so response is never cached. */
            function getQuoteUrl() {
                var sep = QUOTE_API.indexOf('?') === -1 ? '?' : '&';
                return QUOTE_API + sep + '_=' + Date.now();
            }

            /**
             * Fetches a random quote from the API and updates the DOM.
             * On success: shows quote and author with a short fade.
             * On failure: shows fallback message and author.
             * @param {boolean} isRetry - true when this is a single retry after detecting a repeat (no further retries).
             */
            function fetchQuote(isRetry) {
                isRetry = !!isRetry;
                var url = getQuoteUrl();
                console.log('[Quote] Fetch running' + (isRetry ? ' (retry after repeat)' : '') + ', url: ' + url);

                quoteLoadingEl.classList.remove('hidden');
                quoteContentEl.classList.add('hidden');

                fetch(url, { cache: 'no-store' })
                    .then(function (response) {
                        if (!response.ok) throw new Error('API error');
                        return response.json();
                    })
                    .then(function (data) {
                        var text = (data && data.text) ? data.text : FALLBACK_QUOTE;
                        var author = (data && data.author) ? data.author : FALLBACK_AUTHOR;

                        if (!isRetry && text && text === lastQuoteText) {
                            console.log('[Quote] Repeat detected, fetching again once.');
                            fetchQuote(true);
                            return;
                        }
                        lastQuoteText = text;
                        showQuote(text, author);
                    })
                    .catch(function () {
                        showQuote(FALLBACK_QUOTE, FALLBACK_AUTHOR);
                    });
            }

            /**
             * Renders quote and author with a brief fade-in effect.
             */
            function showQuote(text, author) {
                quoteLoadingEl.classList.add('hidden');

                if (quoteTextEl.classList.contains('quote-visible')) {
                    quoteTextEl.classList.remove('quote-visible');
                    quoteTextEl.classList.add('quote-updating');
                }
                quoteTextEl.textContent = text;
                quoteAuthorEl.textContent = '\u2014 ' + author;

                quoteContentEl.classList.remove('hidden');
                quoteTextEl.classList.remove('quote-updating');
                quoteTextEl.classList.add('quote-visible');
            }

            // Load first quote when the page is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', fetchQuote);
            } else {
                fetchQuote();
            }
            // Refresh quote every 30 seconds without reloading the page
            setInterval(fetchQuote, REFRESH_INTERVAL_MS);
        })();
    </script>
</x-app-layout>
