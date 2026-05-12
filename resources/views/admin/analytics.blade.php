<!DOCTYPE html>
<html>
<head>
    <title>Analytics | CraveCart Admin</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: #0f0f12;
            color: #fff;
        }
    </style>
</head>

<body>

<div class="max-w-6xl mx-auto p-6">
    <div class="bg-[#15151a] border-b border-red-900 px-6 py-4 flex justify-between items-center">

    <div>
        <h1 class="text-xl font-bold text-red-500">CraveCart Admin</h1>
    </div>

    <div class="flex gap-3">

        <!-- DASHBOARD BUTTON -->
        <a href="{{ route('admin.dashboard') }}"
           class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition">
            Dashboard
        </a>

    </div>

</div>

<div class="max-w-6xl mx-auto p-6">


    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-red-500">📊 Analytics Dashboard</h1>
        <p class="text-gray-400">Overview of platform activity</p>
    </div>

    <!-- STATS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

        <div class="bg-[#1a1a1f] border border-red-900 p-6 rounded-xl shadow-lg text-center">
            <h2 class="text-3xl font-bold text-red-500">{{ $totalUsers }}</h2>
            <p class="text-gray-400">Total Users</p>
        </div>

        <div class="bg-[#1a1a1f] border border-red-900 p-6 rounded-xl shadow-lg text-center">
            <h2 class="text-3xl font-bold text-orange-400">{{ $sellers }}</h2>
            <p class="text-gray-400">Sellers</p>
        </div>

        <div class="bg-[#1a1a1f] border border-red-900 p-6 rounded-xl shadow-lg text-center">
            <h2 class="text-3xl font-bold text-red-300">{{ $buyers }}</h2>
            <p class="text-gray-400">Buyers</p>
        </div>

        <div class="bg-[#1a1a1f] border border-red-900 p-6 rounded-xl shadow-lg text-center">
            <h2 class="text-3xl font-bold text-red-600">{{ $blocked }}</h2>
            <p class="text-gray-400">Blocked</p>
        </div>

    </div>

    <!-- CHART -->
    <div class="bg-[#1a1a1f] border border-red-900 p-6 rounded-xl shadow-lg">
        <canvas id="userChart"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const data = window.analyticsData || {};

    new Chart(document.getElementById('userChart'), {
        type: 'bar',
        data: {
            labels: ['Total', 'Sellers', 'Buyers', 'Blocked'],
            datasets: [{
                label: 'Users',
                data: [
                    data.totalUsers || 0,
                    data.sellers || 0,
                    data.buyers || 0,
                    data.blocked || 0
                ],
                backgroundColor: ['#3b82f6','#facc15','#10b981','#ef4444']
            }]
        }
    });

});
</script>

</body>
</html>