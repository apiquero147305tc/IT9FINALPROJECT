<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics | CraveCart Admin</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: #f8fafc;
            color: #0f172a;
        }
    </style>
</head>

<body class="antialiased font-sans">

    <!-- TOP NAVBAR -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 backdrop-blur-md bg-opacity-90">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-xl font-black tracking-wider bg-gradient-to-r from-red-500 to-orange-500 bg-clip-text text-transparent">
                    CRAVECART ADMIN
                </h1>
            </div>
            <div>
                <a href="{{ route('admin.dashboard') }}"
                   class="bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-500 hover:to-orange-500 text-white font-medium px-5 py-2 rounded-xl text-sm transition-all duration-200 shadow-md shadow-red-500/10 hover:shadow-orange-500/20 hover:-translate-y-0.5 inline-block">
                    Dashboard
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN CONTAINER -->
    <main class="max-w-6xl mx-auto p-6 md:py-10">

        <!-- HEADER -->
        <div class="mb-10">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 flex items-center gap-3">
                <span class="bg-gradient-to-r from-red-600 to-orange-500 bg-clip-text text-transparent">📊 Analytics Dashboard</span>
            </h1>
            <p class="text-slate-500 mt-1 text-sm md:text-base">Real-time overview of your platform activity.</p>
        </div>

        <!-- STATS CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-10">

            <!-- TOTAL USERS -->
            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm relative overflow-hidden group hover:border-red-500/40 transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-red-500 to-red-600"></div>
                <h2 class="text-4xl font-black text-slate-900 tracking-tight mb-1">{{ $totalUsers }}</h2>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Users</p>
            </div>

            <!-- SELLERS -->
            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm relative overflow-hidden group hover:border-orange-500/40 transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-red-500 to-orange-500"></div>
                <h2 class="text-4xl font-black bg-gradient-to-r from-red-500 to-orange-500 bg-clip-text text-transparent tracking-tight mb-1">{{ $sellers }}</h2>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Sellers</p>
            </div>

            <!-- BUYERS -->
            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm relative overflow-hidden group hover:border-orange-400/40 transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-orange-500 to-amber-500"></div>
                <h2 class="text-4xl font-black text-orange-500 tracking-tight mb-1">{{ $buyers }}</h2>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Buyers</p>
            </div>

            <!-- BLOCKED -->
            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm relative overflow-hidden group hover:border-slate-400 transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-slate-400"></div>
                <h2 class="text-4xl font-black text-slate-400 tracking-tight mb-1">{{ $blocked }}</h2>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Blocked</p>
            </div>

        </div>

        <!-- CHART SECTION -->
        <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-slate-800">User Distribution</h3>
            </div>
            <div class="relative w-full h-[350px]">
                <canvas id="userChart"></canvas>
            </div>
        </div>

    </main>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const data = window.analyticsData || {
            totalUsers: {{ $totalUsers ?? 0 }},
            sellers: {{ $sellers ?? 0 }},
            buyers: {{ $buyers ?? 0 }},
            blocked: {{ $blocked ?? 0 }}
        };

        const ctx = document.getElementById('userChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Users', 'Sellers', 'Buyers', 'Blocked'],
                datasets: [{
                    label: 'Platform Count',
                    data: [
                        data.totalUsers,
                        data.sellers,
                        data.buyers,
                        data.blocked
                    ],
                    // High-contrast clean colors for light mode
                    backgroundColor: ['#ef4444', '#f97316', '#f59e0b', '#94a3b8'],
                    borderRadius: 8,
                    borderSkipped: false,
                    barThickness: 40
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
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                family: 'ui-sans-serif, system-ui',
                                weight: '500'
                            }
                        }
                    },
                    y: {
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            color: '#94a3b8'
                        }
                    }
                }
            }
        });
    });
    </script>

</body>
</html>