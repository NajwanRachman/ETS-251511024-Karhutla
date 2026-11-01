<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan - Karhutla Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100">

    <nav class="bg-green-700 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="font-bold text-xl">🌳 Karhutla Report</h1>

        <div class="flex gap-3">
            <a href="{{ route('reporter.dashboard') }}"
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

            <h2 class="text-2xl font-bold text-gray-800">
                Buat Laporan Kebakaran
            </h2>

            <p class="text-gray-500 mt-2 mb-6">
                Isi informasi kejadian kebakaran hutan dan lahan dengan lengkap.
            </p>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                action="{{ route('reporter.reports.store') }}"
                enctype="multipart/form-data">

                @csrf

                <div class="mb-4">
                    <label class="block font-semibold mb-2">
                        Lokasi Wilayah
                    </label>

                    <select name="address_id"
                        class="w-full border rounded-lg p-3"
                        required>

                        <option value="">Pilih wilayah</option>

                        @foreach ($addresses as $address)
                            <option value="{{ $address->address_id }}"
                                {{ old('address_id') == $address->address_id ? 'selected' : '' }}>
                                {{ $address->detail_address }},
                                {{ $address->city_regency }},
                                {{ $address->province }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-2">
                        Detail Kejadian
                    </label>

                    <textarea name="report_description"
                        rows="4"
                        class="w-full border rounded-lg p-3"
                        placeholder="Jelaskan kondisi kebakaran yang ditemukan..."
                        required>{{ old('report_description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-2">
                        Waktu Kejadian
                    </label>

                    <input type="datetime-local"
                        name="incident_time"
                        value="{{ old('incident_time') }}"
                        class="w-full border rounded-lg p-3"
                        required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-2">
                        Tingkat Kondisi
                    </label>

                    <select name="condition_level"
                        class="w-full border rounded-lg p-3"
                        required>

                        <option value="">Pilih tingkat kondisi</option>

                        <option value="low" {{ old('condition_level') == 'low' ? 'selected' : '' }}>
                            Rendah
                        </option>

                        <option value="medium" {{ old('condition_level') == 'medium' ? 'selected' : '' }}>
                            Sedang
                        </option>

                        <option value="high" {{ old('condition_level') == 'high' ? 'selected' : '' }}>
                            Tinggi
                        </option>

                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                    <div>
                        <label class="block font-semibold mb-2">
                            Latitude
                        </label>

                        <input type="number"
                            name="latitude"
                            step="any"
                            min="-90"
                            max="90"
                            value="{{ old('latitude') }}"
                            class="w-full border rounded-lg p-3"
                            placeholder="-6.9000000"
                            required>
                    </div>

                    <div>
                        <label class="block font-semibold mb-2">
                            Longitude
                        </label>

                        <input type="number"
                            name="longitude"
                            step="any"
                            min="-180"
                            max="180"
                            value="{{ old('longitude') }}"
                            class="w-full border rounded-lg p-3"
                            placeholder="107.6000000"
                            required>
                    </div>

                </div>

                <div class="mb-6">
                    <label class="block font-semibold mb-2">
                        Bukti Kejadian
                    </label>

                    <input type="file"
                        name="evidence_file"
                        accept=".jpg,.jpeg,.png,.pdf"
                        class="w-full border rounded-lg p-3">

                    <p class="text-sm text-gray-500 mt-2">
                        Format JPG, JPEG, PNG, atau PDF. Maksimal 2 MB.
                    </p>
                </div>

                <button type="submit"
                    class="bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded-lg">
                    Kirim Laporan
                </button>

            </form>

        </div>

    </main>

</body>
</html>
