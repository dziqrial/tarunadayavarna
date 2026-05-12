<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\KuisHasil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('rw');

        $totalKuis = KuisHasil::where('user_id', $user->id)->count();
        $avgSkor   = KuisHasil::where('user_id', $user->id)->avg('skor') ?? 0;

        return view('app.profil', compact('user', 'totalKuis', 'avgSkor'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nama'         => 'required|string|max:150',
            'no_wa'        => 'nullable|string|max:20',
            'email'        => 'nullable|email|unique:users,email,' . $user->id,
            'foto_profil'  => 'nullable|image|max:2048',
            'password'     => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'nama'  => $request->nama,
            'no_wa' => $request->no_wa,
            'email' => $request->email,
        ];

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('profil', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
