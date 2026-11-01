<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teruskan Laporan - Karhutla Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-green-700 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="font-bold text-xl">🌳 Karhutla Report</h1>

        <a href="{{ route('coordinator.forwardings.index') }}"
            class="bg-white text-green-700 px-4 py-2 rounded-lg">
            Kembali
        </a>
    </nav>

    <main class="max-w-3xl mx-auto p-6">

        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            Form Penerusan Laporan #{{ $report->report_id }}
        </h2>

        <p class="text-gray-500 mb-6">
            Lengkapi informasi instansi tujuan penerusan laporan.
        </p>

        <div class="bg-white rounded-xl shadow p-6">

            <div class="mb-6 bg-green-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Informasi Laporan</h3>

                <p><strong>Reporter:</strong> {{ $report->reporter->name }}</p>

                <p><strong>Lokasi:</strong>
                    {{ $report->address->city_regency }},
                    {{ $report->address->province }}
                </p>

                <p><strong>Kondisi:</strong>
                    {{ ucfirst($report->condition_level) }}
                </p>

                <p><strong>Status:</strong> Ditinjau</p>
            </div>

            <form action="{{ route('coordinator.forwardings.store', $report->report_id) }}"
                method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block font-semibold mb-2">
                        Nama Instansi Tujuan
                    </label>

                    <input type="text" name="destination_name"
                        value="{{ old('destination_name') }}"
                        placeholder="Contoh: BPBD Kabupaten Bandung"
                        class="w-full border rounded-lg p-3" required>

                    @error('destination_name')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-2">
                        Tanggal dan Waktu Penerusan
                    </label>

                    <input type="datetime-local" name="forwarded_at"
                        value="{{ old('forwarded_at', now()->format('Y-m-d\TH:i')) }}"
                        class="w-full border rounded-lg p-3" required>

                    @error('forwarded_at')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-2">
                        Catatan Penerusan
                    </label>

                    <textarea name="forwarding_note" rows="4"
                        placeholder="Tambahkan informasi atau catatan penerusan..."
                        class="w-full border rounded-lg p-3">{{ old('forwarding_note') }}</textarea>

                    @error('forwarding_note')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="bg-green-700 hover:bg-green-800 text-white px-5 py-3 rounded-lg">
                    Simpan Penerusan
                </button>

            </form>
        </div>

    </main>

</body>
</html>
