<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Karhutla Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100">

    <nav class="bg-green-700 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="font-bold text-xl">🌳 Karhutla Report</h1>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-white text-green-700 px-4 py-2 rounded-lg">
                Logout
            </button>
        </form>
    </nav>

    <main class="max-w-6xl mx-auto p-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Selamat Datang, {{ Auth::user()->name }}!
            </h2>

            <p class="text-gray-500 mt-2">
                Anda login sebagai:
                <span class="font-semibold text-green-700">
                    {{ ucfirst(Auth::user()->role) }}
                </span>
            </p>

            <p class="mt-4 text-gray-600">
                Selamat datang di sistem pelaporan kebakaran hutan dan lahan.
            </p>
        </div>
    </main>

</body>
</html>
