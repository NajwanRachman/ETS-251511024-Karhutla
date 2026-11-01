<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Laporan - Karhutla Report</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <div class="max-w-7xl mx-auto px-6 py-8">

        <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Rekapitulasi Laporan
                </h1>
                <p class="text-gray-500 mt-2">
                    Ringkasan data laporan kebakaran hutan dan lahan.
                </p>
            </div>

            <a href="{{ route('coordinator.dashboard') }}"
                class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-3 rounded-lg">
                Kembali ke Dashboard
            </a>
        </div>

        <!-- Filter -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
            <form action="{{ route('coordinator.recap') }}" method="GET"
                class="flex flex-wrap items-end gap-4">

                <div class="flex-1 min-w-52">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Filter Status Laporan
                    </label>

                    <select name="status"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3">
                        <option value="">Semua Status</option>
                        <option value="submitted" @selected($status === 'submitted')>
                            Menunggu
                        </option>
                        <option value="under_review" @selected($status === 'under_review')>
                            Sedang Ditinjau
                        </option>
                        <option value="reviewed" @selected($status === 'reviewed')>
                            Telah Ditinjau
                        </option>
                        <option value="forwarded" @selected($status === 'forwarded')>
                            Diteruskan
                        </option>
                        <option value="closed" @selected($status === 'closed')>
                            Selesai
                        </option>
                    </select>
                </div>

                <button type="submit"
                    class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-3 rounded-lg">
                    Terapkan Filter
                </button>

                <a href="{{ route('coordinator.recap') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg">
                    Reset
                </a>
            </form>
        </div>

        <!-- Tiga Metrik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-600">
                <p class="text-gray-500 text-sm">Total Laporan</p>
                <h2 class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $totalReports }}
                </h2>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
                <p class="text-gray-500 text-sm">Laporan Aktif</p>
                <h2 class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $activeReports }}
                </h2>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-600">
                <p class="text-gray-500 text-sm">Laporan Diteruskan / Selesai</p>
                <h2 class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $forwardedReports }}
                </h2>
            </div>

        </div>

        <!-- Tabel Laporan -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">

            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-800">
                    Data Laporan
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Pelapor</th>
                            <th class="px-6 py-4">Wilayah</th>
                            <th class="px-6 py-4">Kondisi</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Waktu Kejadian</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse ($reports as $report)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium">
                                    #{{ $report->report_id }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $report->reporter->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $report->address->detail_address ?? '-' }},
                                    {{ $report->address->city_regency ?? '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ ucfirst($report->condition_level) }}
                                </td>

                                <td class="px-6 py-4">
                                    @php
                                        $statusLabels = [
                                            'submitted' => 'Menunggu',
                                            'under_review' => 'Sedang Ditinjau',
                                            'reviewed' => 'Telah Ditinjau',
                                            'forwarded' => 'Diteruskan',
                                            'closed' => 'Selesai',
                                        ];
                                    @endphp

                                    {{ $statusLabels[$report->status] ?? $report->status }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $report->incident_time->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="px-6 py-8 text-center text-gray-500">
                                    Tidak ada laporan yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-6">
                {{ $reports->links() }}
            </div>

        </div>

    </div>

</body>
</html>
