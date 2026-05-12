<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\NotifikasiUser;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $notifikasis = NotifikasiUser::where('user_id', $user->id)
            ->with('notifikasi')
            ->orderByDesc('created_at')
            ->paginate(20);

        // Mark all as read
        NotifikasiUser::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return view('app.notifikasi', compact('notifikasis'));
    }

    public function markRead(int $id)
    {
        NotifikasiUser::where('id', $id)
            ->where('user_id', auth()->id())
            ->update(['is_read' => true, 'read_at' => now()]);

        return back();
    }
}
