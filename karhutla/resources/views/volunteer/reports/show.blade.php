<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan - Karhutla Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-green-700 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="font-bold text-xl">🌳 Karhutla Report</h1>

        <div class="flex gap-3">
            <a href="{{ route('volunteer.reports.index') }}"
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

    <!-- Konten -->
    <main class="max-w-4xl mx-auto p-6">

        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            Detail Laporan #{{ $report->report_id }}
        </h2>

        <p class="text-gray-500 mb-6">
            Periksa informasi dan bukti laporan dari Reporter.
        </p>

        <!-- Pesan Notifikasi -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow p-6 space-y-5">

            <!-- Informasi Pelapor -->
            <section>
                <h3 class="font-semibold text-lg mb-3">
                    Informasi Pelapor
                </h3>

                <p><strong>Nama:</strong> {{ $report->reporter->name }}</p>
                <p><strong>Email:</strong> {{ $report->reporter->email }}</p>
            </section>

            <hr>

            <!-- Informasi Kejadian -->
            <section>
                <h3 class="font-semibold text-lg mb-3">
                    Informasi Kejadian
                </h3>

                <p>
                    <strong>Lokasi:</strong>
                    {{ $report->address->detail_address }},
                    {{ $report->address->city_regency }},
                    {{ $report->address->province }}
                </p>

                <p>
                    <strong>Waktu:</strong>
                    {{ $report->incident_time->format('d/m/Y H:i') }}
                </p>

                <p>
                    <strong>Kondisi:</strong>
                    {{ ucfirst($report->condition_level) }}
                </p>

                <p><strong>Latitude:</strong> {{ $report->latitude }}</p>
                <p><strong>Longitude:</strong> {{ $report->longitude }}</p>

                <div class="mt-3">
                    <strong>Deskripsi:</strong>
                    <p class="text-gray-700 mt-1">
                        {{ $report->report_description }}
                    </p>
                </div>
            </section>

            <hr>

            <!-- Bukti Kejadian -->
            <section>
                <h3 class="font-semibold text-lg mb-3">
                    Bukti Kejadian
                </h3>

                @if ($report->evidence_file)
                    <a href="{{ asset('storage/' . $report->evidence_file) }}"
                        target="_blank"
                        class="text-blue-600 hover:underline">
                        Lihat Bukti Laporan
                    </a>
                @else
                    <p class="text-gray-500">
                        Tidak ada bukti yang dilampirkan.
                    </p>
                @endif
            </section>

            <hr>

            <!-- Riwayat Pemeriksaan -->
            <section>
                <h3 class="font-semibold text-lg mb-3">
                    Riwayat Pemeriksaan
                </h3>

                @forelse ($report->reviews as $review)
                    <div class="border rounded-lg p-4 mb-3">

                        <p>
                            <strong>Volunteer:</strong>
                            {{ $review->volunteer->name }}
                        </p>

                        <p>
                            <strong>Hasil Pemeriksaan:</strong>
                            {{ $review->review_data ?? '-' }}
                        </p>

                        <p>
                            <strong>Catatan:</strong>
                            {{ $review->review_note ?? '-' }}
                        </p>

                        <p>
                            <strong>Perlu diteruskan:</strong>
                            {{ $review->follow_up_required ? 'Ya' : 'Tidak' }}
                        </p>

                    </div>
                @empty
                    <p class="text-gray-500">
                        Belum ada pemeriksaan.
                    </p>
                @endforelse
            </section>

            <!-- Form Pemeriksaan -->
            @if (in_array($report->status, ['submitted', 'under_review']))

                <hr>

                <section>
                    <h3 class="font-semibold text-lg mb-4">
                        Form Pemeriksaan Volunteer
                    </h3>

                    <form action="{{ route('volunteer.reports.review', $report->report_id) }}"
                        method="POST"
                        class="space-y-4">

                        @csrf

                        <!-- Hasil Pemeriksaan -->
                        <div>
                            <label class="block font-semibold mb-2">
                                Hasil Pemeriksaan
                            </label>

                            <select name="review_data"
                                class="w-full border rounded-lg p-3"
                                required>
                                <option value="">Pilih hasil pemeriksaan</option>
                                <option value="layak" {{ old('review_data') == 'layak' ? 'selected' : '' }}>
                                    Layak diteruskan
                                </option>
                                <option value="tidak_layak" {{ old('review_data') == 'tidak_layak' ? 'selected' : '' }}>
                                    Tidak layak diteruskan
                                </option>
                            </select>

                            @error('review_data')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catatan Pemeriksaan -->
                        <div>
                            <label class="block font-semibold mb-2">
                                Catatan Pemeriksaan
                            </label>

                            <textarea name="review_note"
                                rows="4"
                                class="w-full border rounded-lg p-3"
                                placeholder="Tuliskan hasil pengecekan laporan..."
                                required>{{ old('review_note') }}</textarea>

                            @error('review_note')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tindak Lanjut -->
                        <div>
                            <label class="block font-semibold mb-2">
                                Perlu Tindak Lanjut?
                            </label>

                            <select name="follow_up_required"
                                class="w-full border rounded-lg p-3"
                                required>
                                <option value="">Pilih jawaban</option>
                                <option value="1" {{ old('follow_up_required') == '1' ? 'selected' : '' }}>
                                    Ya
                                </option>
                                <option value="0" {{ old('follow_up_required') == '0' ? 'selected' : '' }}>
                                    Tidak
                                </option>
                            </select>

                            @error('follow_up_required')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="bg-green-700 hover:bg-green-800 text-white px-5 py-3 rounded-lg">
                            Simpan Pemeriksaan
                        </button>

                    </form>
                </section>

            @else

                <div class="bg-gray-100 border rounded-lg p-4">
                    <p class="text-gray-600">
                        Laporan ini tidak tersedia untuk pemeriksaan ulang.
                    </p>
                </div>

            @endif

        </div>
    </main>

</body>
</html>
