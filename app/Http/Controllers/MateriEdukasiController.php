<?php
namespace App\Http\Controllers;

use App\Models\MateriEdukasi;
use Illuminate\Support\Facades\Auth;

class MateriEdukasiController extends Controller
{
    public function index()
    {
        // Cek role: hanya pengguna dan ukm yang boleh akses
        if (! in_array(Auth::user()->role, ['pengguna', 'ukm'])) {
            abort(403, 'Unauthorized access');
        }

        $materi = MateriEdukasi::latest()->get();

        return view('materi-edukasi', compact('materi'));
    }
    public function show($id)
    {
        $materi = MateriEdukasi::findOrFail($id);
        return view('detail-materi', compact('materi'));
    }
}