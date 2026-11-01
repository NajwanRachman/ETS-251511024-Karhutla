<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Menampilkan daftar pengguna
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('coordinator.users.index', compact('users'));
    }

    // Mengubah role pengguna
    public function updateRole(Request $request, $id)
    {
        $validated = $request->validate([
            'role' => ['required', 'in:reporter,volunteer,coordinator'],
        ]);

        $user = User::where('user_id', $id)->firstOrFail();

        // Coordinator tidak boleh mengubah role akunnya sendiri
        if ($user->user_id == Auth::id()) {
            return back()->with('error', 'Anda tidak dapat mengubah role akun sendiri.');
        }

        $user->update([
            'role' => $validated['role'],
        ]);

        return back()->with('success', 'Role pengguna berhasil diperbarui.');
    }
}
