<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penerusan Laporan - Karhutla Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-green-700 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="font-bold text-xl">🌳 Karhutla Report</h1>

        <div class="flex gap-3">
            <a href="{{ route('coordinator.dashboard') }}"
                class="bg-white text-green-700 px-4 py-2 rounded-lg">
                Dashboard
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="bg-white text-green-700 px-4 py-2 rounded-lg">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto p-6">

        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            Daftar Laporan Siap Diteruskan
        </h2>

        <p class="text-gray-500 mb-6">
            Laporan yang sudah ditinjau oleh Volunteer dan siap diteruskan ke instansi tujuan.
        </p>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-5">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-x-auto">

            <table class="w-full text-left">
                <thead class="bg-green-50">
                    <tr>
                        <th class="p-4">ID</th>
                        <th class="p-4">Reporter</th>
                        <th class="p-4">Lokasi</th>
                        <th class="p-4">Kondisi</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reports as $report)
                        <tr class="border-t">
                            <td class="p-4">#{{ $report->report_id }}</td>

                            <td class="p-4">
                                {{ $report->reporter->name }}
                            </td>

                            <td class="p-4">
                                {{ $report->address->city_regency }},
                                {{ $report->address->province }}
                            </td>

                            <td class="p-4">
                                {{ ucfirst($report->condition_level) }}
                            </td>

                            <td class="p-4">
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
                                    Ditinjau
                                </span>
                            </td>

                            <td class="p-4">
                                <a href="{{ route('coordinator.forwardings.create', $report->report_id) }}"
                                    class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg">
                                    Teruskan
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-500">
                                Belum ada laporan yang siap diteruskan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        <div class="mt-5">
            {{ $reports->links() }}
        </div>

    </main>

</body>
</html>
