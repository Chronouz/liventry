<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Liventry</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/homepage.js')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <div x-data="{ showSidebar: false, showCalendar: false }" class="flex h-screen">
        <!-- Navbar -->
        <div class="fixed top-0 left-0 w-full bg-diaroBlue text-white p-4 z-50 h-16 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <!-- Ikon Liventry -->
                <img src="https://storage.googleapis.com/a1aa/image/sKdLhKCvQiyzi6yTZqr_JXCci2n6kEaWoKpiTuU9o_8.jpg" class="w-8 h-8 md:w-10 md:h-10" alt="Logo">
                <!-- Teks Liventry -->
                <span class="text-lg md:text-xl font-bold">Liventry</span>
            </div>
            <div class="flex items-center">
            </div>
            <a href="{{ route('catatan.create') }}" class="btn-add-entry bg-yellow-500 text-black px-4 py-2 rounded">+ ADD ENTRY</a>
        </div>

        <!-- Sidebar -->
        <div class="sidebar hidden md:block pt-16">
          <div class="sidebar-user">
            <img src="https://storage.googleapis.com/a1aa/image/IrIQ_IwIfWa6r6p9cvLh445BzvFA260qa2_UB5VdaP8.jpg" alt="User">
            <div>
              <div>support@gmail.com</div>
              <div class="text-sm">Liventry Debugger Team</div>
            </div>
          </div>
      
          <div class="flex-1 p-4">
            <div class="mb-4">
              <input class="w-full p-2 rounded bg-white text-black" placeholder="Search" type="text"/>
            </div>
      
            <div class="bg-white text-black rounded p-4">
              <div class="relative mb-2" x-data="{ showMonthYear: false }">
                <div class="flex flex-col sm:flex-row justify-center items-center gap-2 sm:gap-4 mb-6">
                    <button onclick="changeMonth(-1)" class="text-lg font-bold text-blue-600 hover:text-blue-800">←</button>
                    
                    <div class="cursor-pointer px-3 py-1 border border-pink-300 rounded bg-white hover:bg-pink-100 text-center shadow"
                         @click="showMonthYear = !showMonthYear">
                        <span id="monthYearSidebar" class="font-bold"></span>
                    </div>
            
                    <button onclick="changeMonth(1)" class="text-lg font-bold text-blue-600 hover:text-blue-800">→</button>
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
      
        <!-- Navbar for Small Screens -->
        <div class="fixed top-4 left-4 z-50 flex items-center gap-4 md:hidden">
          <!-- Ikon Liventry -->
          <img src="https://storage.googleapis.com/a1aa/image/sKdLhKCvQiyzi6yTZqr_JXCci2n6kEaWoKpiTuU9o_8.jpg" class="w-8 h-8 md:w-10 md:h-10" alt="Logo">
          <!-- Teks Liventry -->
          <span class="text-lg md:text-xl font-bold text-white">Liventry</span>
          <!-- Ikon Kalender -->
          <button 
              class="bg-blue-500 text-white p-2 rounded inline-flex items-center justify-center" 
              @click="showCalendar = !showCalendar"
          >
              <i class="fas fa-calendar-alt"></i>
          </button>
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
      
      <script>
        let today = new Date();
        let current = new Date(today.getFullYear(), today.getMonth(), 1);
      
        function renderCalendar(date) {
          const calendarGrid = document.getElementById('calendarGrid');
          const calendarGridMobile = document.getElementById('calendarGridMobile');
          const monthYearSidebar = document.getElementById('monthYearSidebar');
          const monthYearPopup = document.getElementById('monthYearPopup');
          if (!calendarGrid || (!monthYearSidebar && !monthYearPopup)) return;
      
          const monthYearText = date.toLocaleString('default', { month: 'long', year: 'numeric' });
          if (monthYearSidebar) monthYearSidebar.textContent = monthYearText;
          if (monthYearPopup) monthYearPopup.textContent = monthYearText;
      
          const year = date.getFullYear();
          const month = date.getMonth();
          current = new Date(year, month, 1);
      
          const firstDay = new Date(year, month, 1).getDay();
          const daysInMonth = new Date(year, month + 1, 0).getDate();
          const today = new Date();
      
          // Reset grids
          calendarGrid.innerHTML = '';
          if (calendarGridMobile) calendarGridMobile.innerHTML = '';
      
          const renderTo = (container) => {
              for (let i = 0; i < firstDay; i++) {
                  container.innerHTML += `<div></div>`;
              }
              for (let d = 1; d <= daysInMonth; d++) {
                  const isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
                  container.innerHTML += `
                      <div onclick="filterByDate('${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}')"
                          class="cursor-pointer p-2 rounded border text-sm ${isToday ? 'bg-blue-500 text-white font-bold' : 'hover:bg-pink-100'}">
                          ${d}
                      </div>`;
              }
          };
      
          renderTo(calendarGrid);
          if (calendarGridMobile) renderTo(calendarGridMobile);
        }
      
        function selectMonth(m) {
          current.setMonth(m);
          renderCalendar(current);
        }
      
        function selectYear(y) {
          current.setFullYear(y);
          renderCalendar(current);
        }
      
        function changeMonth(diff) {
          current.setMonth(current.getMonth() + diff);
          renderCalendar(current);
        }
      
        function filterByDate(date) {
          window.location.href = `/?tanggal=${date}`;
        }
      
        document.addEventListener('DOMContentLoaded', () => {
          renderCalendar(current);
        });
      </script>
</body>
</html>
