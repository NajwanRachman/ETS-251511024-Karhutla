<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Karhutla Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">

        <div class="text-center mb-8">
            <div class="text-4xl mb-3">🌳</div>
            <h1 class="text-2xl font-bold text-gray-800">
                Karhutla Report
            </h1>
            <p class="text-gray-500 mt-2">
                Sistem Pelaporan Kebakaran Hutan dan Lahan
            </p>
        </div>

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                >

                @error('email')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                >

                @error('password')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center mb-6">
                <input
                    type="checkbox"
                    name="remember"
                    value="1"
                    class="w-4 h-4 text-green-600"
                >
                <label class="ml-2 text-sm text-gray-600">
                    Ingat saya
                </label>
            </div>

            <button
                type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition"
            >
                Masuk
            </button>
        </form>

        <p class="text-center text-sm text-gray-400 mt-8">
            &copy; {{ date('Y') }} Karhutla Report
        </p>

    </div>

</body>
</html>
