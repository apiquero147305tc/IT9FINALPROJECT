<!DOCTYPE html>
<html>
<head>
    <title>Analytics | CraveCart Admin</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: #faf8f5;
            color: #0f172a;
        }
    </style>
</head>

<body>

<div class="max-w-6xl mx-auto p-6">

    {{-- Top Navigation Bar --}}
    <div class="bg-white border border-slate-100 rounded-2xl px-6 py-4 flex justify-between items-center mb-8 shadow-sm">

        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center border border-red-100">
                <span class="text-xl">📊</span>
            </div>
            <div>
                <h1 class="text-lg font-black text-slate-900 tracking-tight">CraveCart <span class="text-red-600">Admin.</span></h1>
            </div>
        </div>

        <div class="flex gap-3">

            <a href="{{ route('admin.dashboard') }}"
               class="bg-slate-900 hover:bg-red-600 text-white font-black px-6 py-3 rounded-xl text-[11px] tracking-[0.15em] uppercase transition-all duration-300 shadow-lg hover:shadow-xl">
                Dashboard
            </a>

        </div>

    </div>

    {{-- Header Section --}}
    <div class="text-center mb-12">
        <div class="inline-block bg-red-100 border border-red-200 rounded-full px-4 py-1.5 mb-4">
            <span class="text-red-600 text-[10px] font-black tracking-[0.4em] uppercase">Studio Analytics</span>
        </div>
        <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-[0.9]">
            Platform <span class="text-red-600">Insights.</span>
        </h2>
        <p class="mt-4 text-slate-400 font-bold text-[11px] tracking-[0.3em] uppercase">
            CraveCart Essentials Hub
        </p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

        <div class="bg-white border border-slate-100 p-8 rounded-[35px] shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-500 text-center group">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-50 rounded-2xl mb-4 group-hover:bg-slate-900 group-hover:rotate-12 transition-all duration-500 shadow-inner">
                <span class="text-3xl group-hover:scale-110 transition-transform">👥</span>
            </div>
            <h2 class="text-4xl font-black text-slate-900 tracking-tight">{{ $totalUsers }}</h2>
            <p class="text-slate-400 font-bold text-[11px] tracking-[0.2em] uppercase mt-2">Total Users</p>
            <div class="w-full h-1 bg-slate-100 rounded-full mt-4 overflow-hidden">
                <div class="h-full bg-slate-900 rounded-full group-hover:bg-red-600 transition-colors duration-500" style="width: 100%"></div>
            </div>
        </div>

        <div class="bg-white border border-slate-100 p-8 rounded-[35px] shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-500 text-center group">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-rose-50 rounded-2xl mb-4 group-hover:bg-red-600 group-hover:-rotate-12 transition-all duration-500 shadow-inner">
                <span class="text-3xl group-hover:scale-110 transition-transform">🏪</span>
            </div>
            <h2 class="text-4xl font-black text-red-600 tracking-tight">{{ $sellers }}</h2>
            <p class="text-slate-400 font-bold text-[11px] tracking-[0.2em] uppercase mt-2">Sellers</p>
            <div class="w-full h-1 bg-slate-100 rounded-full mt-4 overflow-hidden">
                <div class="h-full bg-red-600 rounded-full group-hover:bg-slate-900 transition-colors duration-500" style="width: {{ $totalUsers > 0 ? ($sellers / $totalUsers * 100) : 0 }}%"></div>
            </div>
        </div>

        <div class="bg-white border border-slate-100 p-8 rounded-[35px] shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-500 text-center group">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-red-50 rounded-2xl mb-4 group-hover:bg-red-500 group-hover:rotate-6 transition-all duration-500 shadow-inner">
                <span class="text-3xl group-hover:scale-110 transition-transform">🎒</span>
            </div>
            <h2 class="text-4xl font-black text-red-500 tracking-tight">{{ $buyers }}</h2>
            <p class="text-slate-400 font-bold text-[11px] tracking-[0.2em] uppercase mt-2">Buyers</p>
            <div class="w-full h-1 bg-slate-100 rounded-full mt-4 overflow-hidden">
                <div class="h-full bg-red-500 rounded-full group-hover:bg-slate-900 transition-colors duration-500" style="width: {{ $totalUsers > 0 ? ($buyers / $totalUsers * 100) : 0 }}%"></div>
            </div>
        </div>

        <div class="bg-white border border-slate-100 p-8 rounded-[35px] shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-500 text-center group">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-2xl mb-4 group-hover:bg-gray-800 group-hover:rotate-12 transition-all duration-500 shadow-inner">
                <span class="text-3xl group-hover:scale-110 transition-transform">🚫</span>
            </div>
            <h2 class="text-4xl font-black text-gray-700 tracking-tight">{{ $blocked }}</h2>
            <p class="text-slate-400 font-bold text-[11px] tracking-[0.2em] uppercase mt-2">Blocked</p>
            <div class="w-full h-1 bg-slate-100 rounded-full mt-4 overflow-hidden">
                <div class="h-full bg-gray-700 rounded-full group-hover:bg-red-600 transition-colors duration-500" style="width: {{ $totalUsers > 0 ? ($blocked / $totalUsers * 100) : 0 }}%"></div>
            </div>
        </div>

    </div>

    {{-- Chart Section --}}
    <div class="bg-white border border-slate-100 p-8 rounded-[35px] shadow-sm mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase">User Distribution</h3>
                <p class="text-slate-400 text-xs font-bold tracking-wider uppercase mt-1">Platform Overview</p>
            </div>
            <div class="bg-red-50 border border-red-100 rounded-full px-4 py-1.5">
                <span class="text-red-600 text-[10px] font-black tracking-[0.3em] uppercase">Live Data</span>
            </div>
        </div>
        <div class="h-80">
            <canvas id="userChart"></canvas>
        </div>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const data = window.analyticsData || {};

    new Chart(document.getElementById('userChart'), {
        type: 'bar',
        data: {
            labels: ['Total Users', 'Sellers', 'Buyers', 'Blocked'],
            datasets: [{
                label: 'Platform Users',
                data: [
                    data.totalUsers || 0,
                    data.sellers || 0,
                    data.buyers || 0,
                    data.blocked || 0
                ],
                backgroundColor: ['#0f172a', '#dc2626', '#ef4444', '#374151'],
                borderRadius: 12,
                borderSkipped: false,
                barThickness: 60
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f5f9'
                    },
                    ticks: {
                        color: '#94a3b8',
                        font: {
                            size: 11,
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#64748b',
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                }
            }
        }
    });

});
</script>

</body>
</html>