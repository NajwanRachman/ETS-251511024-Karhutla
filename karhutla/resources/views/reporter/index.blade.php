<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan - Karhutla Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100">

    <nav class="bg-green-700 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="font-bold text-xl">🌳 Karhutla Report</h1>

        <div class="flex gap-3">
            <a href="{{ route('reporter.dashboard') }}"
                class="bg-white text-green-700 px-4 py-2 rounded-lg">
                Dashboard
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-white text-green-700 px-4 py-2 rounded-lg">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto p-6">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Daftar Laporan Saya
                </h2>
                <p class="text-gray-500 mt-1">
                    Pantau seluruh laporan kebakaran yang telah kamu kirim.
                </p>
            </div>

            <a href="{{ route('reporter.reports.create') }}"
                class="bg-green-700 hover:bg-green-800 text-white px-5 py-3 rounded-lg">
                + Buat Laporan
            </a>
        </div>

        <!-- Pencarian dan Filter -->
        <div class="bg-white rounded-xl shadow p-5 mb-6">

            <form action="{{ route('reporter.reports.index') }}" method="GET">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div>
                        <label class="block font-semibold mb-2">
                            Cari Laporan
                        </label>

                        <input type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="ID atau nama wilayah..."
                            class="w-full border rounded-lg p-3">
                    </div>

                    <div>
                        <label class="block font-semibold mb-2">
                            Filter Status
                        </label>

                        <select name="status"
                            class="w-full border rounded-lg p-3">

                            <option value="">Semua Status</option>
                            <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>
                                Dikirim
                            </option>
                            <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>
                                Dalam Pemeriksaan
                            </option>
                            <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>
                                Ditinjau
                            </option>
                            <option value="forwarded" {{ request('status') == 'forwarded' ? 'selected' : '' }}>
                                Diteruskan
                            </option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>
                                Selesai
                            </option>

                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold mb-2">
                            Filter Kondisi
                        </label>

                        <select name="condition"
                            class="w-full border rounded-lg p-3">

                            <option value="">Semua Kondisi</option>
                            <option value="low" {{ request('condition') == 'low' ? 'selected' : '' }}>
                                Rendah
                            </option>
                            <option value="medium" {{ request('condition') == 'medium' ? 'selected' : '' }}>
                                Sedang
                            </option>
                            <option value="high" {{ request('condition') == 'high' ? 'selected' : '' }}>
                                Tinggi
                            </option>

                        </select>
                    </div>

                </div>

                <div class="flex gap-2 mt-4">
                    <button type="submit"
                        class="bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded-lg">
                        Cari dan Filter
                    </button>

                    <a href="{{ route('reporter.reports.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg">
                        Reset
                    </a>
                </div>

            </form>

        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full text-left">

                    <thead class="bg-green-50 text-gray-700">
                        <tr>
                            <th class="p-4">ID</th>
                            <th class="p-4">Lokasi</th>
                            <th class="p-4">Waktu Kejadian</th>
                            <th class="p-4">Kondisi</th>
                            <th class="p-4">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @forelse ($reports as $report)
                            <tr class="hover:bg-gray-50">

                                <td class="p-4">
                                    <a href="{{ route('reporter.reports.show', $report->report_id) }}"
                                        class="text-green-700 font-semibold hover:underline">
                                        #{{ $report->report_id }}
                                    </a>
                                </td>

                                <td class="p-4">
                                    {{ $report->address->city_regency ?? '-' }},
                                    {{ $report->address->province ?? '-' }}
                                </td>

                                <td class="p-4">
                                    {{ $report->incident_time->format('d/m/Y H:i') }}
                                </td>

                                <td class="p-4">
                                    @if ($report->condition_level === 'low')
                                        Rendah
                                    @elseif ($report->condition_level === 'medium')
                                        Sedang
                                    @else
                                        Tinggi
                                    @endif
                                </td>

                                <td class="p-4">
                                    @if ($report->status === 'submitted')
                                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
                                            Dikirim
                                        </span>
                                    @elseif ($report->status === 'under_review')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                                            Dalam Pemeriksaan
                                        </span>
                                    @elseif ($report->status === 'reviewed')
                                        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm">
                                            Ditinjau
                                        </span>
                                    @elseif ($report->status === 'forwarded')
                                        <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm">
                                            Diteruskan
                                        </span>
                                    @elseif ($report->status === 'closed')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                            Selesai
                                        </span>
                                    @endif
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500">
                                    Tidak ada laporan yang sesuai dengan pencarian atau filter.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t">
                {{ $reports->links() }}
            </div>

        </div>

    </main>

</body>
</html>
