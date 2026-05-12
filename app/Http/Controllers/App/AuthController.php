<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Rw;
use App\Models\User;
use App\Services\NotifikasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('app.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Username atau password salah.')->withInput();
        }

        if (!$user->is_active) {
            return back()->with('error', 'Akun Anda belum diaktifkan. Tunggu persetujuan admin RW.')->withInput();
        }

        Auth::login($user, $request->boolean('remember'));

        if (in_array($user->role, ['super_admin', 'admin_rw'])) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('app.beranda');
    }

    public function registerPage()
    {
        $rws = Rw::orderBy('nama')->get();
        return view('app.auth.register', compact('rws'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:150',
            'username' => 'required|string|max:100|unique:users,username',
            'email'    => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'rw_id'    => 'required|exists:rw,id',
            'no_wa'    => 'nullable|string|max:20',
        ], [
            'username.unique' => 'Username sudah digunakan.',
            'email.unique'    => 'Email sudah digunakan.',
        ]);

        $user = User::create([
            'nama'      => $request->nama,
            'username'  => $request->username,
            'email'     => $request->email,
            'password'  => $request->password,
            'role'      => 'warga',
            'rw_id'     => $request->rw_id,
            'no_wa'     => $request->no_wa,
            'is_active' => false,
        ]);

        // Notifikasi ke admin RW
        $adminRw = User::where('role', 'admin_rw')
            ->where('rw_id', $request->rw_id)
            ->first();

        if ($adminRw) {
            app(NotifikasiService::class)->kirimKeUser(
                $adminRw->id,
                'Pendaftaran Warga Baru',
                "Warga baru {$user->nama} mendaftar di RW Anda. Silakan tinjau dan aktivasi akun.",
                'info'
            );
        }

        return redirect()->route('app.login')
            ->with('success', 'Pendaftaran berhasil! Tunggu persetujuan admin RW untuk dapat login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('app.login')->with('success', 'Anda telah logout.');
    }
}
