<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan - Volunteer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100">

    <nav class="bg-green-700 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="font-bold text-xl">🌳 Karhutla Report</h1>

        <div class="flex gap-3">
            <a href="{{ route('volunteer.dashboard') }}"
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

    <main class="max-w-7xl mx-auto p-6">

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Daftar Laporan Masuk
            </h2>

            <p class="text-gray-500 mt-1">
                Periksa laporan indikasi kebakaran hutan dan lahan.
            </p>
        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full text-left">

                    <thead class="bg-green-50 text-gray-700">
                        <tr>
                            <th class="p-4">ID</th>
                            <th class="p-4">Pelapor</th>
                            <th class="p-4">Lokasi</th>
                            <th class="p-4">Waktu</th>
                            <th class="p-4">Kondisi</th>
                            <th class="p-4">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @forelse ($reports as $report)
                            <tr class="hover:bg-gray-50">

                                <td class="p-4 font-semibold">
                                    <a href="{{ route('volunteer.reports.show', $report->report_id) }}"
                                        class="text-green-700 hover:underline">
                                        #{{ $report->report_id }}
                                    </a>
                                </td>

                                <td class="p-4">
                                    {{ $report->reporter->name ?? '-' }}
                                </td>

                                <td class="p-4">
                                    {{ $report->address->city_regency ?? '-' }},
                                    {{ $report->address->province ?? '-' }}
                                </td>

                                <td class="p-4 whitespace-nowrap">
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
                                <td colspan="6" class="p-8 text-center text-gray-500">
                                    Belum ada laporan masuk.
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
