import flatpickr from "flatpickr";

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
      
        window.selectMonth = function (m) {
          current.setMonth(m);
          renderCalendar(current);
        }
      
        window.selectYear = function (y) {
          current.setFullYear(y);
          renderCalendar(current);
        }
      
        window.changeMonth = function (diff) {
          current.setMonth(current.getMonth() + diff);
          renderCalendar(current);
        }
      
        function filterByDate(date) {
          window.location.href = `/?tanggal=${date}`;
        }
      
        document.addEventListener('DOMContentLoaded', () => {
          renderCalendar(current);
        });

        window.previewImage = function (event) {
            const input = event.target;
            const previewContainer = document.getElementById('imagePreview');
            const previewImage = previewContainer.querySelector('img');
        
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                previewImage.src = '';
                previewImage.classList.add('hidden');
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            // Inisialisasi Flatpickr untuk input tanggal
            flatpickr('.flatpickr', {
                dateFormat: 'Y-m-d', // Format tanggal
                altInput: true,
                altFormat: 'F j, Y', // Format tampilan
            });
        
            // Inisialisasi Flatpickr untuk input waktu
            flatpickr('.timepicker', {
                enableTime: true,
                noCalendar: true,
                dateFormat: 'H:i', // Format waktu
                time_24hr: true, // Format 24 jam
            });
        });