<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function adminIndex()
    {
        $users = User::where('role', 'admin')->latest()->paginate(10);
        return view('admin.users.index', ['users' => $users, 'role' => 'admin']);
    }

    public function operatorIndex()
    {
        $users = User::where('role', 'operator')->latest()->paginate(10);
        return view('admin.users.index', ['users' => $users, 'role' => 'operator']);
    }

    public function create(Request $request)
    {
        $role = $request->get('role', 'admin');
        return view('admin.users.create', compact('role'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'role' => ['required', 'in:admin,operator'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 100 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 100 karakter.',
            'email.unique' => 'Email sudah digunakan.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role yang dipilih tidak valid.',
        ], [
            'name' => 'nama',
            'email' => 'email',
            'role' => 'role',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make('temp1234'),
        ]);

        $generatedPassword = $this->generatedPassword($user->email, $user->id);
        $user->update([
            'password' => Hash::make($generatedPassword),
            'password_text' => $generatedPassword,
        ]);

        return redirect()
            ->route($validated['role'] === 'admin' ? 'admin.users.admin' : 'admin.users.operator')
            ->with('generated_password', 'Password user baru: ' . $generatedPassword)
            ->with('success', 'User berhasil dibuat.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
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

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['new_password'])) {
            $payload['password'] = Hash::make($validated['new_password']);
            $payload['password_text'] = null;
        }

        $user->update($payload);

        return redirect()
            ->route($user->role === 'admin' ? 'admin.users.admin' : 'admin.users.operator')
            ->with('success', 'User berhasil diubah.');
    }

    public function resetPassword(User $user)
    {
        $generatedPassword = $this->generatedPassword($user->email, $user->id);

        $user->update([
            'password' => Hash::make($generatedPassword),
            // Password reset tetap dipakai untuk login, tapi tidak ditampilkan lagi di export.
            'password_text' => null,
        ]);

        return redirect()->route('admin.users.operator')
            ->with('generated_password', 'Password baru: ' . $generatedPassword)
            ->with('success', 'Password user berhasil di-reset.');
    }

    public function exportAdmin()
    {
        return $this->exportByRole('admin');
    }

    public function exportOperator()
    {
        return $this->exportByRole('operator');
    }

    public function destroy(User $user)
    {
        if ((int) auth()->id() === (int) $user->id) {
            return back()->with('success', 'Akun yang sedang dipakai login tidak dapat dihapus.');
        }

        $targetRole = $user->role;
        $user->delete();

        return redirect()
            ->route($targetRole === 'admin' ? 'admin.users.admin' : 'admin.users.operator')
            ->with('success', 'User berhasil dihapus.');
    }

    private function exportByRole(string $role)
    {
        $users = User::where('role', $role)->orderBy('name')->get();

        $rows = [
            ['Name', 'Email', 'Password'],
        ];

        foreach ($users as $user) {
            $rows[] = [
                $user->name,
                $user->email,
                $user->password_text ?: 'this account already edited the password',
            ];
        }

        return response($this->toXls($rows), 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"users-{$role}-export.xls\"",
        ]);
    }

    private function generatedPassword(string $email, int $id): string
    {
        return strtolower(substr($email, 0, 4)) . $id;
    }

    private function toXls(array $rows): string
    {
        $lines = ["\xEF\xBB\xBF"];
        foreach ($rows as $row) {
            $lines[] = implode("\t", array_map(function ($value) {
                $text = (string) $value;
                $text = str_replace(["\r\n", "\r", "\n", "\t"], [' ', ' ', ' ', ' '], $text);

                return $text;
            }, $row));
        }

        return implode("\r\n", $lines);
    }
}
