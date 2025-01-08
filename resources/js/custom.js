
// Scroll table automatically
function picScroll(element) {
    $(element).each(function () {
        var _this = $(this);
        var ul = _this.find("table");
        var li = ul.find("tbody");
        var w = li.length * li.outerHeight();
        li.clone().prependTo(ul);
        var i = 1,
            l;

        _this.hover(
            function () {
                i = 0;
            },
            function () {
                i = 1;
            }
        );

        function autoScroll() {
            l = _this.scrollTop();
            if (l >= w) {
                _this.scrollTop(0);
            } else {
                _this.scrollTop(l + i);
            }
        }

        setInterval(autoScroll, 70);
    });
}

// Todo: simplify fetcher, it's duplicated
async function getMonthlyData(year) {
    try {
        const response = await fetch(`/api/years/${year}/monthly-data`);
        if (!response.ok) {
            throw new Error(`Error ${response.status}: ${response.statusText}`);
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Error fetching data:", error.message);
        throw error;
    }
}

async function fetchMonthlyData(year, useCallback = false, callback = null) {
    try {
        const data = await getMonthlyData(year);

        if (useCallback && typeof callback === "function") {
            callback(data);
        } else {
            return data;
        }
    } catch (error) {
        console.error("Failed to fetch monthly data:", error.message);
        throw error; // Melanjutkan error untuk penanganan di luar fungsi
    }
}

async function fetchAttendanceLeaders(useCallback = false, callback = null) {
    try {
        const response = await fetch("/api/attendance-leaders");

        if (!response.ok) {
            throw new Error(
                `Error: ${response.status} - ${response.statusText}`
            );
        }

        const data = await response.json();

        if (data.success) {
            if (useCallback && typeof callback === "function") {
                callback(data.data);
            }

            return data.data;
        } else {
            console.error("Failed to retrieve attendance data:", data.message);
        }
    } catch (error) {
        console.error(
            "An error occurred while fetching attendance data:",
            error.message
        );
    }
}

async function fetchRunningText(useCallback = false, callback = null) {
    try {
        const response = await fetch("/api/news");

        if (!response.ok) {
            throw new Error(
                `Error: ${response.status} - ${response.statusText}`
            );
        }

        const data = await response.json();

        if (data.success) {
            if (useCallback && typeof callback === "function") {
                callback(data.data);
            }

            return data.data;
        } else {
            console.error("Failed to retrieve data:", data.message);
        }
    } catch (error) {
        console.error(
            "An error occurred while fetching data:",
            error.message
        );
    }
}

async function fetchAds(useCallback = false, callback = null) {
    try {
        const response = await fetch("/api/ads");

        if (!response.ok) {
            throw new Error(
                `Error: ${response.status} - ${response.statusText}`
            );
        }

        const data = await response.json();

        if (data.success) {
            if (useCallback && typeof callback === "function") {
                callback(data.data);
            }

            return data.data;
        } else {
            console.error("Failed to retrieve data:", data.message);
        }
    } catch (error) {
        console.error(
            "An error occurred while fetching data:",
            error.message
        );
    }
}

async function fetchVid(useCallback = false, callback = null) {
    try {
        const response = await fetch("/api/vid");

        if (!response.ok) {
            throw new Error(
                `Error: ${response.status} - ${response.statusText}`
            );
        }

        const data = await response.json();

        if (data.success) {
            if (useCallback && typeof callback === "function") {
                callback(data.data);
            }

            return data.data;
        } else {
            console.error("Failed to retrieve data:", data.message);
        }
    } catch (error) {
        console.error(
            "An error occurred while fetching data:",
            error.message
        );
    }
}

// Try to simplify fetcher
async function fetchData(url, useCallback = false, callback = null) {
    try {
        const response = await fetch(url);

        if (!response.ok) {
            throw new Error(
                `Error: ${response.status} - ${response.statusText}`
            );
        }

        const data = await response.json();

        if (data.success) {
            if (useCallback && typeof callback === "function") {
                callback(data.data);
            }

            return data.data;
        } else {
            console.error(`Failed to retrieve data from ${url}:`, data.message);
        }
    } catch (error) {
        console.error(
            `An error occurred while fetching data from ${url}:`,
            error.message
        );
    }
}

// Todo: simplify populate function
// only use container id (automatic get child so it's easier to change theme)
function populateTable(data, tableId) {
    $(`#${tableId} tbody`).empty();

    data.months.forEach((month, index) => {
        const collection = data.collections[index];
        const distribution = data.distributions[index];

        const rowHtml = `
            <tr class="
                odd:bg-green-100
                even:bg-green-50
                [&:nth-child(2)]:*:odd:bg-yellow-100
                [&:nth-child(2)]:*:even:bg-yellow-50
                [&:nth-child(3)]:*:odd:bg-teal-100
                [&:nth-child(3)]:*:even:bg-teal-50
                ">
                <td class="px-6 py-3 whitespace-nowrap text-md font-semibold text-gray-800">
                    ${month}
                </td>
                <td class="px-6 py-3 whitespace-nowrap text-md text-end font-bold text-yellow-900">
                    <span class="font-normal text-sm">Rp</span>${collection.toLocaleString()}
                </td>
                <td class="px-6 py-3 whitespace-nowrap text-md text-end font-bold text-teal-800">
                    <span class="font-normal text-sm">Rp</span>${distribution.toLocaleString()}
                </td>
            </tr>
        `;

        $(`#${tableId} tbody`).append(rowHtml);
    });
}

async function populateChart(elementId, collection, distribution) {
    const currentDate = new Date();
    let year;

    if (currentDate.getMonth() === 0) {
        year = currentDate.getFullYear() - 1;
    } else {
        year = currentDate.getFullYear();
    }

    console.log(year);

    // Menambahkan HTML ke elemen dengan ID tertentu
    document.getElementById(elementId).innerHTML = `
    <div class="w-1/2 flex flex-col gap-1">
        <div class="p-3 flex flex-col bg-white border shadow-sm rounded-xl">
            <div class="flex justify-center items-center">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 ">
                        Penghimpunan
                    </h2>
                </div>
            </div>
            <p
                class="inline-flex justify-center items-center py-1.5 px-3 rounded-md text-2xl font-bold bg-yellow-100 text-yellow-800 ">
                <span class="font-medium text-lg">Rp</span>${collection
                    .reduce((a, b) => a + b, 0)
                    .toLocaleString()}
            </p>
        </div>

        <div class="p-3 flex flex-col bg-white border shadow-sm rounded-xl">
            <!-- Header -->
            <div class="flex justify-center items-center">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 ">
                        Penghimpunan ${year}
                    </h2>
                </div>

            </div>
            <!-- End Header -->

            <div id="chart-collection"></div>
        </div>
    </div>
    <div class="w-1/2 flex flex-col gap-1">
        <div class="p-3 flex flex-col bg-white border shadow-sm rounded-xl">
            <div class="flex justify-center items-center">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 ">
                        Pendistribusian
                    </h2>
                </div>
            </div>
            <p
                class="inline-flex justify-center items-center py-1.5 px-3 rounded-md text-2xl font-bold bg-teal-100 text-teal-800 ">
                <span class="font-medium text-lg">Rp</span>${distribution
                    .reduce((a, b) => a + b, 0)
                    .toLocaleString()}
            </p>
        </div>

        <div class="p-3 flex flex-col bg-white border shadow-sm rounded-xl">
            <!-- Header -->
            <div class="flex justify-center items-center">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 ">
                        Pendistribusian ${year}
                    </h2>
                </div>
            </div>
            <!-- End Header -->

            <div id="chart-distribution"></div>
        </div>
    </div>
    `;

    const chartHeight = 400;

    // Membuat chart collection menggunakan ApexCharts
    const collectionOptions = {
        chart: {
            type: "line",
            height: chartHeight,
            dropShadow: {
                enabled: true,
                color: "#000",
                top: 18,
                left: 7,
                blur: 10,
                opacity: 0.2,
            },
            zoom: {
                enabled: false,
            },
            toolbar: {
                show: false,
            },
        },
        series: [
            {
                name: "Penghimpunan",
                data: collection, // Data untuk collection chart
            },
        ],
        colors: ["#845020", "#545454"],
        dataLabels: {
            enabled: true,
            style: {
                fontSize: "14px",
                fontFamily: "Helvetica, Arial, sans-serif",
                fontWeight: "bold",
                colors: ["#845020"],
            },
            background: {
                enabled: true,
                foreColor: "#fff",
                padding: 4,
                borderRadius: 2,
                borderWidth: 1,
                borderColor: "#fff",
                opacity: 0.9,
                dropShadow: {
                    enabled: false,
                    top: 1,
                    left: 1,
                    blur: 1,
                    color: "#000",
                    opacity: 0.45,
                },
            },
            formatter: (value) => {
                if (value >= 1000000000) {
                    return `${(value / 1000000000).toFixed(0)} M`; // M untuk Miliaran
                } else if (value >= 1000000) {
                    return `${(value / 1000000).toFixed(0)} Jt`; // Jt untuk Jutaan
                } else if (value >= 1000) {
                    return `${(value / 1000).toFixed(0)} K`; // K untuk Ribuan
                }
                return value; // Tampilkan langsung jika kurang dari 1000
            },
        },
        stroke: {
            curve: "smooth",
        },
        grid: {
            borderColor: "#e7e7e7",
            row: {
                colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
                opacity: 0.5,
            },
        },
        markers: {
            size: 1,
        },
        xaxis: {
            categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "Mei",
                "Jun",
                "Jul",
                "Agu",
                "Sep",
                "Okt",
                "Nov",
                "Des",
            ],
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            crosshairs: {
                show: false,
            },
            labels: {
                style: {
                    colors: "#9ca3af",
                    fontSize: "13px",
                    fontFamily: "Inter, ui-sans-serif",
                    fontWeight: 400,
                },
                offsetX: -2,
            },
        },
        yaxis: {
            labels: {
                align: "left",
                minWidth: 0,
                maxWidth: 140,
                style: {
                    colors: "#9ca3af",
                    fontSize: "13px",
                    fontFamily: "Inter, ui-sans-serif",
                    fontWeight: 400,
                },
                formatter: (value) => {
                    if (value >= 1000000000) {
                        return `${(value / 1000000000).toFixed(0)} M`; // M untuk Miliaran
                    } else if (value >= 1000000) {
                        return `${(value / 1000000).toFixed(0)} Jt`; // Jt untuk Jutaan
                    } else if (value >= 1000) {
                        return `${(value / 1000).toFixed(0)} K`; // K untuk Ribuan
                    }
                    return value; // Tampilkan langsung jika kurang dari 1000
                },
            },
        },
        legend: {
            position: "top",
            horizontalAlign: "right",
            floating: true,
            offsetY: -25,
            offsetX: -5,
        },
    };

    // Membuat chart distribution menggunakan ApexCharts
    const distributionOptions = {
        chart: {
            type: "line",
            height: chartHeight,
            dropShadow: {
                enabled: true,
                color: "#000",
                top: 18,
                left: 7,
                blur: 10,
                opacity: 0.2,
            },
            zoom: {
                enabled: false,
            },
            toolbar: {
                show: false,
            },
        },
        series: [
            {
                name: "Pendistribusian",
                data: distribution, // Data untuk collection chart
            },
        ],
        colors: ["#845020", "#545454"],
        dataLabels: {
            enabled: true,
            style: {
                fontSize: "14px",
                fontFamily: "Helvetica, Arial, sans-serif",
                fontWeight: "bold",
                colors: ["#845020"],
            },
            background: {
                enabled: true,
                foreColor: "#fff",
                padding: 4,
                borderRadius: 2,
                borderWidth: 1,
                borderColor: "#fff",
                opacity: 0.9,
                dropShadow: {
                    enabled: false,
                    top: 1,
                    left: 1,
                    blur: 1,
                    color: "#000",
                    opacity: 0.45,
                },
            },
            formatter: (value) => {
                if (value >= 1000000000) {
                    return `${(value / 1000000000).toFixed(0)} M`; // M untuk Miliaran
                } else if (value >= 1000000) {
                    return `${(value / 1000000).toFixed(0)} Jt`; // Jt untuk Jutaan
                } else if (value >= 1000) {
                    return `${(value / 1000).toFixed(0)} K`; // K untuk Ribuan
                }
                return value; // Tampilkan langsung jika kurang dari 1000
            },
        },
        stroke: {
            curve: "smooth",
        },
        grid: {
            borderColor: "#e7e7e7",
            row: {
                colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
                opacity: 0.5,
            },
        },
        markers: {
            size: 1,
        },
        xaxis: {
            categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "Mei",
                "Jun",
                "Jul",
                "Agu",
                "Sep",
                "Okt",
                "Nov",
                "Des",
            ],
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            crosshairs: {
                show: false,
            },
            labels: {
                style: {
                    colors: "#9ca3af",
                    fontSize: "13px",
                    fontFamily: "Inter, ui-sans-serif",
                    fontWeight: 400,
                },
                offsetX: -2,
            },
        },
        yaxis: {
            labels: {
                align: "left",
                minWidth: 0,
                maxWidth: 140,
                style: {
                    colors: "#9ca3af",
                    fontSize: "13px",
                    fontFamily: "Inter, ui-sans-serif",
                    fontWeight: 400,
                },
                formatter: (value) => {
                    if (value >= 1000000000) {
                        return `${(value / 1000000000).toFixed(0)} M`; // M untuk Miliaran
                    } else if (value >= 1000000) {
                        return `${(value / 1000000).toFixed(0)} Jt`; // Jt untuk Jutaan
                    } else if (value >= 1000) {
                        return `${(value / 1000).toFixed(0)} K`; // K untuk Ribuan
                    }
                    return value; // Tampilkan langsung jika kurang dari 1000
                },
            },
        },
        legend: {
            position: "top",
            horizontalAlign: "right",
            floating: true,
            offsetY: -25,
            offsetX: -5,
        },
    };

    // Render chart untuk collection
    const collectionChart = new ApexCharts(
        document.querySelector("#chart-collection"),
        collectionOptions
    );
    collectionChart.render();

    // Render chart untuk distribution
    const distributionChart = new ApexCharts(
        document.querySelector("#chart-distribution"),
        distributionOptions
    );
    distributionChart.render();
}

function destroyAllCharts() {
    const allCharts = document.querySelectorAll(".apexcharts-canvas");

    allCharts.forEach((chartCanvas) => {
        const chart = ApexCharts.getChartByID(chartCanvas.id);
        if (chart !== undefined) {
            console.log(chart + 'destroyed');

            chart.destroy();
        }
    });
}

function populateAttendance(data,tableId) {
    $(`#${tableId} tbody`).empty();

    const colors = {
        ada: "from-green-500 to-green-700",
        "tidak ada": "from-red-500 to-red-800",
        "dinas luar": "from-blue-500 to-blue-800",
    };

    data.forEach((item, index) => {
        const color = colors[item.attendance_status] || "from-gray-500 to-gray-700";

        const rowHtml = `
            <tr
                class="divide-x-2 divide-green-950 font-bold text-normal bg-gradient-to-r from-slate-50 to-green-100">
                <td
                    class="py-2 bg-gradient-to-r from-emerald-700 to-[#3f6228] bg-clip-text text-transparent uppercase">
                    ${item.position}
                </td>
                <td class="py-1 bg-gradient-to-r ${color} text-white uppercase">${item.attendance_status}</td>
            </tr>
        `;

        $(`#${tableId} tbody`).append(rowHtml);
    });
}

function populateRunningText(data, elementId) {
    $(`#${elementId}`).empty();

    data.forEach((item, index) => {
        const html = `
            <img src="/favicon-32x32.png" alt="divider" class="inline-block size-4 rounded-md bg-white mx-2">
            <span class="text-normal font-medium">${item.text}. </span>
        `;
        $(`#${elementId}`).append(html);
    });

    //  const clone = $(`#${elementId}`).clone();
    //  clone.attr("aria-hidden", "true");
    //  $(`#${elementId}`).after(clone);

}

async function populateAds(data, elementId) {

    const element = document.getElementById(elementId);

    if (!element) {
        console.log(`Element with id "${elementId}" does not exist.`);
        return;
    }

    $(`#${elementId}`).empty();

    let html = ``;

    if (data.length === 0){
        return;
    }

    data.forEach((item, index) => {
            html += `
            <div class="hs-carousel-slide">
                <div class="flex justify-center h-full bg-gray-100">
                    <img class="w-full h-full object-cover" src="storage/${item.path}" alt="${item.id}">
                </div>
            </div>
        `;
        });

    const container = `
        <div
            id="carousel"
            data-hs-carousel='{
                "loadingClasses": "opacity-0",
                "isAutoHeight": true,
                "dotsItemClasses": "hs-carousel-active:bg-blue-700 hs-carousel-active:border-blue-700 size-3 border border-gray-400 rounded-full cursor-pointer",
                "isAutoPlay": true
            }'
        class="relative flex h-full items-center justify-center">
            <div class="hs-carousel relative flex items-center justify-center overflow-hidden w-full min-h-96 bg-white rounded-lg">
                <div class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0">
                    ${html}
                </div>
            </div>

            <button type="button"
                class="hs-carousel-prev hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 start-0 inline-flex justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 rounded-s-lg">
                <span class="text-2xl" aria-hidden="true">
                    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"></path>
                    </svg>
                </span>
                <span class="sr-only">Previous</span>
            </button>
            <button type="button"
                class="hs-carousel-next hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 end-0 inline-flex justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 rounded-e-lg">
                <span class="sr-only">Next</span>
                <span class="text-2xl" aria-hidden="true">
                    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"></path>
                    </svg>
                </span>
            </button>

            <div
                class="hs-carousel-info inline-flex justify-center px-4 absolute bottom-3 start-[50%] -translate-x-[50%] bg-white rounded-lg">
                <span class="hs-carousel-info-current me-1">0</span>
                /
                <span class="hs-carousel-info-total ms-1">0</span>
            </div>
        </div>
    `;

    $(`#${elementId}`).append(container);
    // $(`#${elementId}`).append(html);

    new HSCarousel(document.querySelector(`#carousel`), {
        isAutoPlay: true,
        isInfiniteLoop: true,
        isAutoHeight: true,
    });

}

async function changeVideoSource(data, videoId) {
    var video = document.getElementById(videoId);

    if(data === null){
        return;
    }

    var source = video.querySelector("source");

    if (source) {
        source.src = 'storage/' + data.attachment;

        video.load();
        // video.play();
    } else {
        console.error("Tidak ditemukan elemen <source> dalam video.");
    }
}

function getFormattedDate() {
    // Array nama hari dan bulan dalam bahasa Indonesia
    const days = [
        "Minggu",
        "Senin",
        "Selasa",
        "Rabu",
        "Kamis",
        "Jumat",
        "Sabtu",
    ];
    const months = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];

    // Ambil tanggal sekarang
    const now = new Date();

    // Format hari, tanggal, bulan, dan tahun
    const dayName = days[now.getDay()];
    const date = now.getDate();
    const monthName = months[now.getMonth()];
    const year = now.getFullYear();

    // Gabungkan hasil menjadi string
    return `${dayName}, ${date} ${monthName} ${year}`;
}

function getCurrentTimeShort() {
    const now = new Date();

    // Ambil jam dan menit
    const hours = String(now.getHours()).padStart(2, "0"); // Tambahkan leading zero jika perlu
    const minutes = String(now.getMinutes()).padStart(2, "0");

    // Gabungkan hasil menjadi format HH:mm
    return `${hours}:${minutes}`;
}



window.picScroll = picScroll;
window.getMonthlyData = getMonthlyData;
window.fetchMonthlyData = fetchMonthlyData;
window.fetchAttendanceLeaders = fetchAttendanceLeaders;
window.fetchRunningText = fetchRunningText;
window.fetchAds = fetchAds;
window.fetchVid = fetchVid;
window.populateTable = populateTable;
window.populateChart = populateChart;
window.populateRunningText = populateRunningText;
window.populateAttendance = populateAttendance;
window.populateAds = populateAds;
window.getFormattedDate = getFormattedDate;
window.getCurrentTimeShort = getCurrentTimeShort;
window.destroyAllCharts = destroyAllCharts;
window.changeVideoSource = changeVideoSource;

// simplified
window.fetchData = fetchData;
