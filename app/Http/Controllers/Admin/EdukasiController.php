<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EdukasiController extends Controller
{
    public function index()
    {
        $edukasi = Edukasi::with('createdBy')->latest()->paginate(20);
        return view('admin.edukasi.index', compact('edukasi'));
    }

    public function create()
    {
        return view('admin.edukasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'        => 'required|string|max:200',
            'konten'       => 'nullable|string',
            'kategori'     => 'required|in:organik,anorganik,b3,daur_ulang',
            'format'       => 'required|in:artikel,video',
            'thumbnail'    => 'nullable|image|max:2048',
            'video_url'    => 'nullable|url',
            'durasi_menit' => 'nullable|integer|min:1',
            'is_published' => 'boolean',
        ]);

        $thumbnailUrl = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailUrl = $request->file('thumbnail')->store('edukasi', 'public');
        }

        Edukasi::create([
            'judul'        => $request->judul,
            'slug'         => Str::slug($request->judul) . '-' . time(),
            'konten'       => $request->konten,
            'kategori'     => $request->kategori,
            'format'       => $request->format,
            'thumbnail_url' => $thumbnailUrl ? \Illuminate\Support\Facades\Storage::url($thumbnailUrl) : null,
            'video_url'    => $request->video_url,
            'durasi_menit' => $request->durasi_menit,
            'is_published' => $request->boolean('is_published'),
            'created_by'   => auth()->id(),
        ]);

        return redirect()->route('admin.edukasi.index')->with('success', 'Konten edukasi berhasil dibuat.');
    }

    public function show(Edukasi $edukasi)
    {
        return redirect()->route('admin.edukasi.edit', $edukasi);
    }

    public function edit(Edukasi $edukasi)
    {
        return view('admin.edukasi.edit', compact('edukasi'));
    }

    public function update(Request $request, Edukasi $edukasi)
    {
        $request->validate([
            'judul'        => 'required|string|max:200',
            'konten'       => 'nullable|string',
            'kategori'     => 'required|in:organik,anorganik,b3,daur_ulang',
            'format'       => 'required|in:artikel,video',
            'video_url'    => 'nullable|url',
            'durasi_menit' => 'nullable|integer|min:1',
            'is_published' => 'boolean',
        ]);

        $data = $request->only(['judul', 'konten', 'kategori', 'format', 'video_url', 'durasi_menit']);
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('thumbnail')) {
            $request->validate(['thumbnail' => 'image|max:2048']);
            $path = $request->file('thumbnail')->store('edukasi', 'public');
            $data['thumbnail_url'] = \Illuminate\Support\Facades\Storage::url($path);
        }

        $edukasi->update($data);

        return redirect()->route('admin.edukasi.index')->with('success', 'Konten edukasi berhasil diperbarui.');
    }

    public function destroy(Edukasi $edukasi)
    {
        $edukasi->delete();
        return redirect()->route('admin.edukasi.index')->with('success', 'Konten edukasi berhasil dihapus.');
    }
}
