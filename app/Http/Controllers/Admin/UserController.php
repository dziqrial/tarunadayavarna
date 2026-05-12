<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rw;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user  = auth()->user();
        $query = User::with('rw');

        if ($user->isAdminRw()) {
            $query->where('rw_id', $user->rw_id)->whereIn('role', ['warga', 'petugas']);
        }

        $users = $query->orderBy('nama')->paginate(20);

        return view('admin.users.index', compact('users', 'user'));
    }

    public function create()
    {
        $authUser = auth()->user();
        $rws      = $authUser->isSuperAdmin() ? Rw::all() : Rw::where('id', $authUser->rw_id)->get();
        $roles    = $authUser->isSuperAdmin()
            ? ['admin_rw' => 'Admin RW', 'petugas' => 'Petugas', 'warga' => 'Warga']
            : ['petugas' => 'Petugas', 'warga' => 'Warga'];

        return view('admin.users.create', compact('rws', 'roles'));
    }

    public function store(Request $request)
    {
        $authUser = auth()->user();

        $request->validate([
            'nama'     => 'required|string|max:150',
            'username' => 'required|string|max:100|unique:users,username',
            'email'    => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin_rw,petugas,warga',
            'rw_id'    => 'nullable|exists:rw,id',
            'no_wa'    => 'nullable|string|max:20',
        ]);

        $rwId = $authUser->isAdminRw() ? $authUser->rw_id : $request->rw_id;

        User::create([
            'nama'      => $request->nama,
            'username'  => $request->username,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'rw_id'     => $rwId,
            'no_wa'     => $request->no_wa,
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $authUser = auth()->user();

        if ($authUser->isAdminRw() && $user->rw_id !== $authUser->rw_id) {
            abort(403);
        }

        $rws   = $authUser->isSuperAdmin() ? Rw::all() : Rw::where('id', $authUser->rw_id)->get();
        $roles = $authUser->isSuperAdmin()
            ? ['admin_rw' => 'Admin RW', 'petugas' => 'Petugas', 'warga' => 'Warga']
            : ['petugas' => 'Petugas', 'warga' => 'Warga'];

        return view('admin.users.edit', compact('user', 'rws', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $authUser = auth()->user();

        if ($authUser->isAdminRw() && $user->rw_id !== $authUser->rw_id) {
            abort(403);
        }

        $request->validate([
            'nama'      => 'required|string|max:150',
            'username'  => 'required|string|max:100|unique:users,username,' . $user->id,
            'email'     => 'nullable|email|unique:users,email,' . $user->id,
            'role'      => 'required|in:admin_rw,petugas,warga',
            'rw_id'     => 'nullable|exists:rw,id',
            'no_wa'     => 'nullable|string|max:20',
            'is_active' => 'boolean',
            'password'  => 'nullable|string|min:6',
        ]);

        $data = [
            'nama'      => $request->nama,
            'username'  => $request->username,
            'email'     => $request->email,
            'role'      => $request->role,
            'rw_id'     => $authUser->isAdminRw() ? $authUser->rw_id : $request->rw_id,
            'no_wa'     => $request->no_wa,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $authUser = auth()->user();

        if ($authUser->isAdminRw() && $user->rw_id !== $authUser->rw_id) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function show(User $user)
    {
        return redirect()->route('admin.users.edit', $user);
    }
}
