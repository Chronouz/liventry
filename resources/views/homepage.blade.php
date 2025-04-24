<!DOCTYPE html>
<html lang="id">
    <script src="//unpkg.com/alpinejs" defer></script>
<head>
    <meta charset="UTF-8">
    <!-- Judul -->
    <title>Liventry - Catat momen terbaik Anda! | Home</title>

    <!-- Ikon Load -->
    <link rel="icon" href="{{ asset('image/icon-liventry.ico') }}" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/homepage.js')
    @livewireStyles
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body>
    @livewireScripts
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <div x-data="{ showSidebar: false, showCalendar: false }" class="flex min-h-screen">
        <!-- Navbar -->
        <div class="fixed top-0 left-0 w-full bg-diaroBlue text-white p-4 z-50 h-16 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <!-- Ikon Liventry -->
                <a href="{{ route('home') }}">
                    <img src="{{ asset('image/logo-liventry.png') }}" class="w-10 h-10" alt="Logo">
                </a>
                
                <!-- Teks Liventry -->
                <a href="{{ route('home') }}" class="text-2xl font-extrabold text-yellow-400 tracking-wide shadow-lg animate-pulse hover:scale-110 transform transition-transform duration-300 ease-in-out font-cursive">
                    Liventry
                </a>
            </div>

            <!-- Tombol Kalender, Tambah Diary, dan Search -->
            <div class="flex items-center gap-2 md:gap-4 flex-row-reverse md:flex-row">
                <!-- Tombol Daftar Catatan -->
                <a href="{{ route('catatan.index') }}" class="btn-list-entry bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Daftar Catatan</a>

                <!-- Tombol Tambah Diary -->
                <a href="{{ route('catatan.create') }}" class="btn-add-entry bg-yellow-500 text-black px-4 py-2 rounded">+ Tambah Diary</a>

                <!-- Kolom Search -->
                <form method="GET" action="{{ url('/') }}" class="flex items-center gap-2">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari judul catatan..." 
                        class="p-2 rounded bg-white text-black border border-gray-300"
                    />
                    {{-- <input type="hidden" name="tanggal" value="{{ request('tanggal', now()->format('Y-m-d')) }}"> --}}
                    <button 
                        type="submit" 
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                    >
                        Cari
                    </button>
                </form>

                <!-- Tombol Kalender (Hanya untuk Layar Kecil) -->
                <button 
                    class="bg-blue-500 text-white p-2 rounded inline-flex items-center justify-center md:hidden" 
                    @click="showCalendar = !showCalendar"
                >
                    <i class="fas fa-calendar-alt"></i>
                </button>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar hidden md:block bg-diaroBlue text-white pt-16 flex-shrink-0">
            <!-- Penampil Waktu Real-Time -->
            <div class="p-4 text-center">
                <div id="realtimeClock" class="text-2xl font-bold"></div>
                <div class="text-sm text-gray-300">Waktu saat ini</div>
            </div>

            <!-- Teks Bergerak -->
            <div class="p-4">
                <div class="breaking-news bg-blue-600 text-white rounded-lg shadow-lg overflow-hidden">
                    <div id="breakingNewsTicker" class="ticker">
                        <ul class="scrolling-text">
                            <li class="py-2"><a href="#">Selamat datang di Liventry.</a></li>
                            <li class="py-2"><a href="#">Catat momen terbaik Anda!</a></li>
                            <li class="py-2"><a href="#">Jangan lupa tambahkan diary hari ini.</a></li>
                            <li class="py-2"><a href="#">Liventry, teman setia Anda!</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex-1 p-4">
                <!--Kolom Search-->
                <div id="weather-bar"
                    class="mb-4 p-4 rounded-lg bg-gradient-to-r from-blue-200 to-blue-400 text-blue-900 shadow-lg transform transition-all duration-500">
                <div class="animate-pulse text-sm">Memuat informasi cuaca...</div>
                </div>

                <div class="bg-white text-black rounded p-4">
                    <div class="relative mb-2" x-data="{ showMonthYear: false }">
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-2 sm:gap-4 mb-6">
                        <button 
                            onclick="changeMonth(-1)" 
                            class="text-blue-600 hover:text-blue-800 transform transition-transform duration-200 hover:scale-110 active:scale-90"
                        >
                            <i class="fas fa-chevron-left text-xl"></i>
                        </button>
                        
                        <div 
                            class="cursor-pointer px-3 py-1 border border-pink-300 rounded bg-white hover:bg-pink-100 text-center shadow transform transition-transform duration-200 hover:scale-105 active:scale-95"
                            @click="showMonthYear = !showMonthYear"
                        >
                            <span id="monthYearSidebar" class="font-bold"></span>
                        </div>
                
                        <button 
                            onclick="changeMonth(1)" 
                            class="text-blue-600 hover:text-blue-800 transform transition-transform duration-200 hover:scale-110 active:scale-90"
                        >
                            <i class="fas fa-chevron-right text-xl"></i>
                        </button>
                    </div>
                
                    <!-- Popup Bulan & Tahun -->
                    <div x-show="showMonthYear" @click.outside="showMonthYear = false"
                    class="absolute z-10 mt-2 w-full sm:w-96 bg-white rounded shadow-lg p-4 grid grid-cols-3 gap-2 max-h-64 overflow-y-auto border border-gray-200">
                        @foreach(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] as $i => $bulan)
                            <div class="cursor-pointer text-center hover:bg-blue-100 rounded p-1 text-sm"
                                onclick="selectMonth({{ $i }}); document.querySelector('[x-data]').__x.$data.showMonthYear = false;">
                                {{ $bulan }}
                            </div>
                        @endforeach
                        <div class="col-span-3 border-t my-2"></div>
                        @php
                        $startYear = 1900;
                        $endYear = now()->year + 10; // kamu bisa sesuaikan sampai tahun berapa
                        @endphp

                        @for($y = $startYear; $y <= $endYear; $y++)
                            <div class="cursor-pointer text-center hover:bg-blue-100 rounded p-1 text-sm"
                                onclick="selectYear({{ $y }}); document.querySelector('[x-data]').__x.$data.showMonthYear = false;">
                                {{ $y }}
                            </div>
                        @endfor
                    </div>
                </div>
                
                <div class="grid grid-cols-7 gap-1 text-center text-sm text-gray-600 sm:text-base">
                    <div>Su</div><div>Mo</div><div>Tu</div><div>We</div><div>Th</div><div>Fr</div><div>Sa</div>
                </div>

                <div class="grid grid-cols-7 gap-1 sm:gap-2 text-center mt-6 mb-8 text-xs sm:text-sm md:text-base lg:text-lg" id="calendarGrid">
                    <!-- Calendar Days Rendered by JS -->
                </div>
            </div>
        </div>
    </div>
        
    <!-- Main Content -->
    <div class="flex-1 flex flex-col pt-16">
        @yield('content')

        <!-- POPUP KALENDER UNTUK MOBILE -->
        <div x-show="showCalendar" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 md:hidden" style="display: none;">
            <div class="bg-white rounded-lg shadow-lg p-4 w-full max-w-md relative" x-data="{ showMonthYear: false }">
                <div class="flex justify-between items-center mb-2">
                    <button onclick="changeMonth(-1)" class="text-lg font-bold text-blue-600 hover:text-blue-800">←</button>
                    <div 
                        class="cursor-pointer border border-pink-300 rounded px-3 py-1 bg-white hover:bg-pink-100"
                        @click="showMonthYear = !showMonthYear"
                    >
                    <span id="monthYearPopup" class="font-bold"></span>
                    </div>
                    <button onclick="changeMonth(1)" class="text-lg font-bold text-blue-600 hover:text-blue-800">→</button>
                </div>
        
                <!-- Popup Bulan dan Tahun -->
                <div 
                    x-show="showMonthYear" 
                    @click.outside="showMonthYear = false"
                    class="absolute z-10 mt-2 w-full bg-white rounded shadow-lg p-4 grid grid-cols-3 gap-2 max-h-64 overflow-y-auto border border-gray-200"
                >
                    @foreach(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] as $i => $bulan)
                        <div 
                            class="cursor-pointer text-center hover:bg-blue-100 rounded p-1 text-sm"
                            onclick="selectMonth({{ $i }}); document.querySelector('[x-data]').__x.$data.showMonthYear = false;"
                        >
                            {{ $bulan }}
                        </div>
                    @endforeach
                    <div class="col-span-3 border-t my-2"></div>
                    @php
                    $startYear = 1900;
                    $endYear = now()->year + 10; // Sesuaikan rentang tahun
                    @endphp
        
                    @for($y = $startYear; $y <= $endYear; $y++)
                        <div 
                            class="cursor-pointer text-center hover:bg-blue-100 rounded p-1 text-sm"
                            onclick="selectYear({{ $y }}); document.querySelector('[x-data]').__x.$data.showMonthYear = false;"
                        >
                            {{ $y }}
                        </div>
                    @endfor
                </div>
        
                <!-- Kalender -->
                <div class="grid grid-cols-7 gap-1 text-center text-sm text-gray-600">
                    <div>Su</div><div>Mo</div><div>Tu</div><div>We</div><div>Th</div><div>Fr</div><div>Sa</div>
                </div>
                <div class="grid grid-cols-7 gap-1 text-center text-sm mt-2" id="calendarGridMobile">
                    <!-- Akan diisi oleh JS -->
                </div>
        
                <!-- Tombol Close -->
                <button class="absolute top-2 right-2 text-gray-400 hover:text-red-500" @click="showCalendar = false">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</body>
</html>
