<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use App\Models\KuisHasil;
use Illuminate\Http\Request;

class EdukasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Edukasi::where('is_published', true);

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }

        $edukasiList = $query->latest()->get();

        $featured = Edukasi::where('is_published', true)->latest()->first();

        return view('app.edukasi.index', compact('edukasiList', 'featured'));
    }

    public function detail(string $slug)
    {
        $edukasi = Edukasi::where('slug', $slug)
            ->where('is_published', true)
            ->with('kuis.soal')
            ->firstOrFail();

        $sudahIkutKuis = false;
        if ($edukasi->kuis) {
            $sudahIkutKuis = KuisHasil::where('kuis_id', $edukasi->kuis->id)
                ->where('user_id', auth()->id())
                ->exists();
        }

        return view('app.edukasi.detail', compact('edukasi', 'sudahIkutKuis'));
    }
}
