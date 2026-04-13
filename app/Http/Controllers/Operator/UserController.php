<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit(User $user)
    {
        // Operator hanya boleh mengedit akun miliknya sendiri.
        if ((int) auth()->id() !== (int) $user->id) {
            abort(403);
        }

        // Tampilkan form edit profil operator.
        return view('operator.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Cegah operator mengubah akun milik user lain.
        if ((int) auth()->id() !== (int) $user->id) {
            abort(403);
        }

        // Validasi data yang diinput sebelum disimpan.
        $validated = $request->validate([
            'name' => ['required', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email,' . $user->id],
            'new_password' => ['nullable', 'string', 'min:6'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 100 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 100 karakter.',
            'email.unique' => 'Email sudah digunakan.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
        ], [
            'name' => 'nama',
            'email' => 'email',
            'new_password' => 'password baru',
        ]);

        // Data dasar yang selalu diperbarui.
        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        // Jika password baru diisi, hash dulu sebelum disimpan.
        if (!empty($validated['new_password'])) {
            $payload['password'] = Hash::make($validated['new_password']);
            $payload['password_text'] = null;
        }

        // Simpan perubahan ke database.
        $user->update($payload);

        // Kembali ke halaman edit dengan pesan sukses.
        return redirect()->route('operator.users.edit', $user)->with('success', 'User berhasil diubah.');
    }
}
