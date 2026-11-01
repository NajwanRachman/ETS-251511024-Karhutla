<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Volunteer - Karhutla Report</title>
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
            Dashboard Volunteer
        </h2>

        <p class="text-gray-600 mt-2">
            Selamat datang, {{ Auth::user()->name }}!
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-6">

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-gray-500">Total Laporan Masuk</h3>
                <p class="text-3xl font-bold text-green-700 mt-2">{{ $totalReports }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-gray-500">Perlu Diperiksa</h3>
                <p class="text-3xl font-bold text-yellow-500 mt-2">{{ $needReview }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-gray-500">Sudah Ditinjau</h3>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $reviewed }}</p>
            </div>

        </div>

        <div class="bg-white p-6 rounded-xl shadow mt-6">
            <h3 class="text-lg font-bold">Menu Pemeriksaan Laporan</h3>

            <p class="text-gray-500 mt-2">
                Periksa kelengkapan laporan, berikan catatan,
                dan perbarui perkembangan pemeriksaan.
            </p>

            <a href="{{ route('volunteer.reports.index') }}"
                class="inline-block bg-green-700 hover:bg-green-800 text-white px-5 py-3 rounded-lg mt-4">
                Lihat Daftar Laporan
            </a>
        </div>

    </main>

</body>
</html>
