import flatpickr from "flatpickr";

let today = new Date();
let current = new Date(today.getFullYear(), today.getMonth(), 1);

function renderCalendar(date) {
    const calendarGrid = document.getElementById("calendarGrid");
    const calendarGridMobile = document.getElementById("calendarGridMobile");
    const monthYearSidebar = document.getElementById("monthYearSidebar");
    const monthYearPopup = document.getElementById("monthYearPopup");
    if (!calendarGrid || (!monthYearSidebar && !monthYearPopup)) return;

    const monthYearText = date.toLocaleString("default", {
        month: "long",
        year: "numeric",
    });
    if (monthYearSidebar) monthYearSidebar.textContent = monthYearText;
    if (monthYearPopup) monthYearPopup.textContent = monthYearText;

    const year = date.getFullYear();
    const month = date.getMonth();
    current = new Date(year, month, 1);

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const today = new Date();

    // Reset grids
    calendarGrid.innerHTML = "";
    if (calendarGridMobile) calendarGridMobile.innerHTML = "";

    const renderTo = (container) => {
        for (let i = 0; i < firstDay; i++) {
            container.innerHTML += `<div></div>`;
        }
        for (let d = 1; d <= daysInMonth; d++) {
            const isToday =
                d === today.getDate() &&
                month === today.getMonth() &&
                year === today.getFullYear();
            container.innerHTML += `
                      <div onclick="filterByDate('${year}-${String(
                month + 1
            ).padStart(2, "0")}-${String(d).padStart(2, "0")}')"
                          class="cursor-pointer p-2 rounded border text-sm ${
                              isToday
                                  ? "bg-blue-500 text-white font-bold"
                                  : "hover:bg-pink-100"
                          }">
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
};

window.selectYear = function (y) {
    current.setFullYear(y);
    renderCalendar(current);
};

window.changeMonth = function (diff) {
    current.setMonth(current.getMonth() + diff);
    renderCalendar(current);
};

window.filterByDate = function (date) {
    window.location.href = `/?tanggal=${date}`;
};

document.addEventListener("DOMContentLoaded", () => {
    renderCalendar(current);
});

window.previewImage = function (event) {
    const previewContainer = document.getElementById("previewContainer");
    const imagePreview = document.getElementById("imagePreview");
    const file = event.target.files[0];

    console.log("File selected:", file); // Debugging: Periksa file yang dipilih

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            console.log("FileReader result:", e.target.result); // Debugging: Periksa hasil FileReader
            imagePreview.src = e.target.result;
            previewContainer.classList.remove("hidden");
        };
        reader.readAsDataURL(file);
    } else {
        console.log("No file selected"); // Debugging: Tidak ada file
        previewContainer.classList.add("hidden");
        imagePreview.src = "";
    }
};

// window.previewImage = function (event) {
//     const input = event.target;
//     const previewContainer = document.getElementById('imagePreview');
//     const previewImage = previewContainer.querySelector('img');

//     if (input.files && input.files[0]) {
//         const reader = new FileReader();
//         reader.onload = function (e) {
//             previewImage.src = e.target.result;
//             previewImage.classList.remove('hidden');
//         };
//         reader.readAsDataURL(input.files[0]);
//     } else {
//         previewImage.src = '';
//         previewImage.classList.add('hidden');
//     }
// };

document.addEventListener("DOMContentLoaded", () => {
    // Inisialisasi Flatpickr untuk input tanggal
    flatpickr(".flatpickr", {
        dateFormat: "Y-m-d", // Format tanggal
        altInput: true,
        altFormat: "F j, Y", // Format tampilan
    });

    // Inisialisasi Flatpickr untuk input waktu
    flatpickr(".timepicker", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i", // Format waktu
        time_24hr: true, // Format 24 jam
    });
});

document.addEventListener("DOMContentLoaded", () => {
    // Render kalender dengan tanggal hari ini
    renderCalendar(current);

    // Redirect ke tanggal hari ini jika halaman dimuat pertama kali
    const urlParams = new URLSearchParams(window.location.search);
    const currentPath = window.location.pathname; // Ambil path URL saat ini

    // Periksa apakah pengguna berada di halaman utama dan URL tidak memiliki parameter `tanggal` atau `search`
    if (
        currentPath === "/" &&
        !urlParams.has("tanggal") &&
        !urlParams.has("search")
    ) {
        const today = new Date();
        const todayString = today.toISOString().split("T")[0];
        window.location.href = `/?tanggal=${todayString}`;
    }

    const weatherBar = document.getElementById("weather-bar");
    const apiKey = "b284fea5b0c04676dd92b966fb0eb5b3"; // Ganti dengan API key OpenWeatherMap kamu

    if (!weatherBar) return;

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            async function (position) {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;

                try {
                    const response = await fetch(
                        `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`
                    );
                    const data = await response.json();

                    const location = data.name;
                    const temp = data.main.temp;
                    const description = data.weather[0].description;
                    const icon = data.weather[0].icon;
                    const iconUrl = `https://openweathermap.org/img/wn/${icon}@2x.png`;

                    // Efek animasi masuk
                    weatherBar.classList.remove("animate-pulse");
                    weatherBar.classList.add("opacity-0");

                    // Tambahkan konten setelah fade
                    setTimeout(() => {
                        weatherBar.innerHTML = `
                            <div class="flex items-center space-x-4">
                                <img src="${iconUrl}" alt="${description}"
                                     class="w-12 h-12 transition transform scale-90 hover:scale-105 duration-300 ease-in-out drop-shadow">
                                <div>
                                    <div class="text-lg font-bold">${location}</div>
                                    <div class="text-sm capitalize">${description}, <span class="font-semibold">${temp}°C</span></div>
                                </div>
                            </div>
                        `;
                        weatherBar.classList.remove("opacity-0");
                        weatherBar.classList.add("opacity-100");
                    }, 300);
                } catch (error) {
                    console.error("Error fetching weather:", error);
                    weatherBar.textContent = "Gagal memuat data cuaca.";
                }
            },
            function (error) {
                console.error("Geolocation error:", error.code, error.message);
                weatherBar.textContent = "Tidak dapat mengakses lokasi Anda.";
            },
            {
                timeout: 10000,
            }
        );
    } else {
        weatherBar.textContent = "Browser tidak mendukung geolocation.";
    }
});

navigator.geolocation.getCurrentPosition(
    function (position) {
        console.log("Lokasi berhasil:", position);
    },
    function (error) {
        console.error("Geolocation error:", error.code, error.message); // ini yang penting
        weatherBar.textContent = "Tidak dapat mengakses lokasi Anda.";
    }
);

function updateClock() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, "0");
    const minutes = String(now.getMinutes()).padStart(2, "0");
    const seconds = String(now.getSeconds()).padStart(2, "0");
    document.getElementById(
        "realtimeClock"
    ).textContent = `${hours}:${minutes}:${seconds}`;
}
setInterval(updateClock, 1000); // Perbarui setiap detik
updateClock(); // Jalankan segera saat halaman dimuat

document.addEventListener("DOMContentLoaded", function () {
    const ticker = document.querySelector(".scrolling-text");
    if (!ticker) {
        console.error("Element .scrolling-text not found");
        return;
    }

    const items = ticker.querySelectorAll("li");
    if (items.length === 0) {
        console.error("No <li> elements found inside .scrolling-text");
        return;
    }

    const itemHeight = items[0].offsetHeight; // Tinggi setiap item
    const totalItems = items.length;

    let index = 0;

    function scrollText() {
        index++;
        if (index >= totalItems) {
            index = 0; // Kembali ke teks pertama
        }
        ticker.style.transform = `translateY(-${index * itemHeight}px)`;
    }

    // Ganti teks setiap 4 detik
    setInterval(scrollText, 4000);
});
