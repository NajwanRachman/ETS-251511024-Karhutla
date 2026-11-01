<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna - Karhutla Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-green-700 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="font-bold text-xl">🌳 Karhutla Report</h1>

        <div class="flex gap-3">
            <a href="{{ route('coordinator.dashboard') }}"
                class="bg-white text-green-700 px-4 py-2 rounded-lg">
                Dashboard
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="bg-white text-green-700 px-4 py-2 rounded-lg">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto p-6">

        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            Manajemen Pengguna
        </h2>

        <p class="text-gray-500 mb-6">
            Kelola akun dan hak akses pengguna Karhutla Report.
        </p>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-5">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-5">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-x-auto">

            <table class="w-full text-left">
                <thead class="bg-green-50">
                    <tr>
                        <th class="p-4">ID</th>
                        <th class="p-4">Nama</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">Ubah Role</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        <tr class="border-t">
                            <td class="p-4">{{ $user->user_id }}</td>

                            <td class="p-4">{{ $user->name }}</td>

                            <td class="p-4">{{ $user->email }}</td>

                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-sm
                                    {{ $user->role == 'coordinator'
                                        ? 'bg-purple-100 text-purple-700'
                                        : ($user->role == 'volunteer'
                                            ? 'bg-blue-100 text-blue-700'
                                            : 'bg-gray-100 text-gray-700') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            <td class="p-4">
                                @if(auth()->id() != $user->user_id)
                                    <form action="{{ route('coordinator.users.updateRole', $user->user_id) }}"
                                        method="POST" class="flex gap-2">
                                        @csrf
                                        @method('PATCH')

                                        <select name="role"
                                            class="border rounded-lg p-2">
                                            <option value="reporter"
                                                {{ $user->role == 'reporter' ? 'selected' : '' }}>
                                                Reporter
                                            </option>

                                            <option value="volunteer"
                                                {{ $user->role == 'volunteer' ? 'selected' : '' }}>
                                                Volunteer
                                            </option>

                                            <option value="coordinator"
                                                {{ $user->role == 'coordinator' ? 'selected' : '' }}>
                                                Coordinator
                                            </option>
                                        </select>

                                        <button type="submit"
                                            class="bg-green-700 hover:bg-green-800 text-white px-3 py-2 rounded-lg">
                                            Simpan
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-sm">
                                        Akun sendiri
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">
                                Belum ada pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        <div class="mt-5">
            {{ $users->links() }}
        </div>

    </main>

</body>
</html>
