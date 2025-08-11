<?php

namespace App\Http\Controllers;

use App\Models\Desain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DesainController extends Controller
{
    // Tampilkan semua desain milik user
    public function index()
    {
        $desains = Desain::where('user_id', Auth::id())->latest()->get();
        return view('ukm.desain', compact('desains'));
    }

    // Tampilkan halaman editor kosong (buat desain baru)
    public function create()
    {
        return view('ukm.editor');
    }

    // Simpan desain baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'canvas_json' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $desain = Desain::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'canvas_json' => $request->canvas_json,
            'thumbnail_url' => $path,
        ]);

        return response()->json([
            'message' => 'Desain berhasil disimpan.',
            'desain_id' => $desain->id,
        ]);
    }

    public function edit($id)
    {
        $desain = Desain::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('ukm.editor', compact('desain'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'canvas_json' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $desain = Desain::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama jika ada
            if ($desain->thumbnail_url) {
                Storage::disk('public')->delete($desain->thumbnail_url);
            }
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $desain->thumbnail_url = $path;
        }

        $desain->judul = $request->judul;
        $desain->canvas_json = $request->canvas_json;
        $desain->save();

        return response()->json([
            'message' => 'Desain berhasil diperbarui.',
            'desain_id' => $desain->id,
        ]);
    }

    public function destroy($id)
    {
        $desain = Desain::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Hapus file thumbnail jika ada
        if ($desain->thumbnail_url) {
            Storage::disk('public')->delete($desain->thumbnail_url);
        }

        // Hapus data desain dari database
        $desain->delete();

        return redirect()->route('ukm.desain')->with('success', 'Desain berhasil dihapus.');
    }
}
