<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan - Karhutla Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-green-700 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="font-bold text-xl">🌳 Karhutla Report</h1>

        <div class="flex gap-3">
            <a href="{{ route('volunteer.reports.index') }}"
                class="bg-white text-green-700 px-4 py-2 rounded-lg">
                Kembali
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="bg-white text-green-700 px-4 py-2 rounded-lg">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto p-6">

        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            Detail Laporan #{{ $report->report_id }}
        </h2>

        <p class="text-gray-500 mb-6">
            Periksa informasi dan bukti laporan dari Reporter.
        </p>

        <div class="bg-white rounded-xl shadow p-6 space-y-5">

            <div>
                <h3 class="font-semibold text-lg mb-3">Informasi Pelapor</h3>

                <p><strong>Nama:</strong> {{ $report->reporter->name }}</p>
                <p><strong>Email:</strong> {{ $report->reporter->email }}</p>
            </div>

            <hr>

            <div>
                <h3 class="font-semibold text-lg mb-3">Informasi Kejadian</h3>

                <p><strong>Lokasi:</strong>
                    {{ $report->address->detail_address }},
                    {{ $report->address->city_regency }},
                    {{ $report->address->province }}
                </p>

                <p><strong>Waktu:</strong>
                    {{ $report->incident_time->format('d/m/Y H:i') }}
                </p>

                <p><strong>Kondisi:</strong>
                    {{ ucfirst($report->condition_level) }}
                </p>

                <p><strong>Latitude:</strong> {{ $report->latitude }}</p>
                <p><strong>Longitude:</strong> {{ $report->longitude }}</p>

                <p class="mt-3"><strong>Deskripsi:</strong></p>
                <p class="text-gray-700">{{ $report->report_description }}</p>
            </div>

            <hr>

            <div>
                <h3 class="font-semibold text-lg mb-3">Bukti Kejadian</h3>
                @if($report->evidence_file)
                    <a href="{{ asset('storage/' . $report->evidence_file) }}"
                        target="_blank"
                        class="text-blue-600 hover:underline">
                        Lihat Bukti Laporan
                    </a>
                @else
                    <p class="text-gray-500">Tidak ada bukti yang dilampirkan.</p>
                @endif
            </div>

            <hr>

            <div>
                <h3 class="font-semibold text-lg mb-3">Riwayat Pemeriksaan</h3>
                
                @if(in_array($report->status, ['submitted', 'under_review']))
                    <hr>

                    <div>
                        <h3 class="font-semibold text-lg mb-4">
                            Form Pemeriksaan Volunteer
                        </h3>

                        @if(session('success'))
                            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('volunteer.reports.review', $report->report_id) }}"
                            method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block font-semibold mb-2">
                                    Hasil Pemeriksaan
                                </label>

                                <select name="review_data"
                                    class="w-full border rounded-lg p-3" required>
                                    <option value="">Pilih hasil pemeriksaan</option>
                                    <option value="layak">Layak diteruskan</option>
                                    <option value="tidak_layak">Tidak layak diteruskan</option>
                                </select>

                                @error('review_data')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block font-semibold mb-2">
                                    Catatan Pemeriksaan
                                </label>

                                <textarea name="review_note" rows="4"
                                    class="w-full border rounded-lg p-3"
                                    placeholder="Tuliskan hasil pengecekan laporan..."
                                    required>{{ old('review_note') }}</textarea>

                                @error('review_note')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block font-semibold mb-2">
                                    Perlu Tindak Lanjut?
                                </label>

                                <select name="follow_up_required"
                                    class="w-full border rounded-lg p-3" required>
                                    <option value="">Pilih jawaban</option>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>

                                @error('follow_up_required')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                class="bg-green-700 hover:bg-green-800 text-white px-5 py-3 rounded-lg">
                                Simpan Pemeriksaan
                            </button>
                        </form>
                    </div>
                @endif

                @forelse($report->reviews as $review)
                    <div class="border rounded-lg p-4 mb-3">
                        <p><strong>Volunteer:</strong>
                            {{ $review->volunteer->name }}
                        </p>

                        <p><strong>Hasil Pemeriksaan:</strong>
                            {{ $review->review_data ?? '-' }}
                        </p>

                        <p><strong>Catatan:</strong>
                            {{ $review->review_note ?? '-' }}
                        </p>

                        <p><strong>Perlu diteruskan:</strong>
                            {{ $review->follow_up_required ? 'Ya' : 'Tidak' }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada pemeriksaan.</p>
                @endforelse
            </div>

        </div>

    </main>

</body>
</html>
