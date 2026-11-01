<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan - Karhutla Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100">

    <nav class="bg-green-700 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="font-bold text-xl">🌳 Karhutla Report</h1>

        <div class="flex gap-3">
            <a href="{{ route('reporter.reports.index') }}"
                class="bg-white text-green-700 px-4 py-2 rounded-lg">
                Kembali
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

    <main class="max-w-4xl mx-auto p-6">

        <div class="bg-white rounded-xl shadow p-6">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        Detail Laporan #{{ $report->report_id }}
                    </h2>

                    <p class="text-gray-500 mt-1">
                        Informasi lengkap laporan kejadian karhutla.
                    </p>
                </div>

                @php
                    $statusLabels = [
                        'submitted' => 'Dikirim',
                        'under_review' => 'Dalam Pemeriksaan',
                        'reviewed' => 'Ditinjau',
                        'forwarded' => 'Diteruskan',
                        'closed' => 'Selesai',
                    ];

                    $statusColors = [
                        'submitted' => 'bg-blue-100 text-blue-700',
                        'under_review' => 'bg-yellow-100 text-yellow-700',
                        'reviewed' => 'bg-purple-100 text-purple-700',
                        'forwarded' => 'bg-indigo-100 text-indigo-700',
                        'closed' => 'bg-green-100 text-green-700',
                    ];
                @endphp

                <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $statusColors[$report->status] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ $statusLabels[$report->status] ?? $report->status }}
                </span>
            </div>

            <hr class="mb-6">

            <h3 class="font-bold text-lg mb-4">Informasi Kejadian</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <p class="text-sm text-gray-500">Lokasi</p>
                    <p class="font-semibold">
                        {{ $report->address->detail_address ?? '-' }},
                        {{ $report->address->city_regency ?? '-' }},
                        {{ $report->address->province ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Waktu Kejadian</p>
                    <p class="font-semibold">
                        {{ $report->incident_time->format('d/m/Y H:i') }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Tingkat Kondisi</p>
                    <p class="font-semibold">
                        @if ($report->condition_level === 'low')
                            Rendah
                        @elseif ($report->condition_level === 'medium')
                            Sedang
                        @else
                            Tinggi
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Koordinat</p>
                    <p class="font-semibold">
                        {{ $report->latitude }}, {{ $report->longitude }}
                    </p>
                </div>

            </div>

            <div class="mt-6">
                <p class="text-sm text-gray-500 mb-2">Deskripsi Kejadian</p>

                <div class="bg-gray-50 p-4 rounded-lg">
                    {{ $report->report_description }}
                </div>
            </div>

            <hr class="my-6">

            <h3 class="font-bold text-lg mb-4">Bukti Kejadian</h3>

            @if ($report->evidence_file)
                @php
                    $extension = strtolower(pathinfo($report->evidence_file, PATHINFO_EXTENSION));
                @endphp

                @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                    <img src="{{ asset('storage/' . $report->evidence_file) }}"
                        alt="Bukti kejadian"
                        class="max-w-full max-h-96 rounded-lg border">
                @elseif ($extension === 'pdf')
                    <a href="{{ asset('storage/' . $report->evidence_file) }}"
                        target="_blank"
                        class="text-green-700 underline">
                        Lihat Bukti PDF
                    </a>
                @endif
            @else
                <p class="text-gray-500">Tidak ada bukti yang dilampirkan.</p>
            @endif

            <hr class="my-6">

            <h3 class="font-bold text-lg mb-4">Catatan Pemeriksaan</h3>

            @forelse ($report->reviews as $review)
                <div class="bg-gray-50 p-4 rounded-lg mb-3">
                    <p class="font-semibold">
                        Volunteer: {{ $review->volunteer->name ?? 'Tidak diketahui' }}
                    </p>

                    <p class="text-sm text-gray-500 mt-1">
                        {{ $review->created_at->format('d/m/Y H:i') }}
                    </p>

                    <p class="mt-3">
                        {{ $review->review_note ?? 'Tidak ada catatan.' }}
                    </p>

                    @if ($review->review_data)
                        <p class="text-sm text-gray-600 mt-2">
                            Hasil pemeriksaan: {{ $review->review_data }}
                        </p>
                    @endif
                </div>
            @empty
                <p class="text-gray-500">
                    Laporan belum memiliki catatan pemeriksaan dari Volunteer.
                </p>
            @endforelse

        </div>

    </main>

</body>
</html>
