<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Reporter - Karhutla Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100">

    <nav class="bg-green-700 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="font-bold text-xl">🌳 Karhutla Report</h1>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="bg-white text-green-700 px-4 py-2 rounded-lg">
                Logout
            </button>
        </form>
    </nav>

    <main class="max-w-6xl mx-auto p-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Dashboard Reporter
        </h2>

        <p class="text-gray-600 mt-2">
            Selamat datang, {{ Auth::user()->name }}!
        </p>
        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded-lg mt-4 mb-4">
                {{ session('success') }}
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-6">

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-gray-500">Total Laporan</h3>
                <p class="text-3xl font-bold text-green-700 mt-2">{{ $totalReports }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-gray-500">Dalam Pemeriksaan</h3>
                <p class="text-3xl font-bold text-yellow-500 mt-2">{{ $underReview }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-gray-500">Selesai</h3>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $completed }}</p>
            </div>

        </div>

        <div class="bg-white p-6 rounded-xl shadow mt-6">
            <h3 class="text-lg font-bold">Menu Laporan</h3>

            <p class="text-gray-500 mt-2">
                Buat laporan indikasi kebakaran hutan dan lahan,
                kemudian pantau perkembangan laporan kamu.
            </p>

                <a href="{{ route('reporter.reports.create') }}"
                class="inline-block bg-green-700 text-white px-5 py-3 rounded-lg mt-4">
                    + Buat Laporan
                </a>

                <a href="{{ route('reporter.reports.index') }}"
                    class="inline-block bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 rounded-lg mt-4 ml-2">
                    Lihat Daftar Laporan
                </a>
        </div>
    </main>

</body>
</html>
