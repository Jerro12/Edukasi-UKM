<?php
namespace App\Http\Controllers;

use App\Models\BabMateri;
use App\Models\JawabanUser;
use App\Models\Kuis;
use App\Models\MateriEdukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriEdukasiController extends Controller
{
    public function index()
    {
        if (! in_array(Auth::user()->role, ['pengguna', 'ukm'])) {
            abort(403, 'Unauthorized access');
        }

        $userId = Auth::id();

        // Ambil semua bab beserta count submateri
        $babMateris = BabMateri::with('subMateri')->withCount('subMateri')->get();

        foreach ($babMateris as $bab) {
            $materiIds = $bab->subMateri->pluck('id');
            $kuisIds   = Kuis::whereIn('materi_id', $materiIds)->pluck('id');

            $jumlahKuis  = count($kuisIds);
            $jumlahBenar = JawabanUser::whereIn('kuis_id', $kuisIds)
                ->where('user_id', $userId)
                ->where('benar', true)
                ->count();

            $totalPoin = $jumlahBenar * 20;

            // 🔥 Batas maksimal 100 poin
            $poinMaks = $jumlahKuis * 20;
            if ($poinMaks > 0) {
                $totalPoin = min(100, ($totalPoin / $poinMaks) * 100);
            } else {
                $totalPoin = 0;
            }

            $bab->total_poin_user = round($totalPoin);
        }

        return view('materi-edukasi.bab-list', compact('babMateris'));
    }
    public function show($id)
    {
        $materi = MateriEdukasi::findOrFail($id);
        return view('detail-materi', compact('materi'));
    }

    public function babList()
    {
        $userId = Auth::id();

        $babMateris = BabMateri::withCount('subMateri')
            ->with(['subMateri.kuis.jawabanUser' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->orderBy('id') // pastikan urutan bab
            ->get();

        $babSebelumnyaLulus = true;

        foreach ($babMateris as $index => $bab) {
            $totalKuis    = 0;
            $jawabanBenar = 0;

            foreach ($bab->subMateri as $materi) {
                foreach ($materi->kuis as $kuis) {
                    $totalKuis++;
                    $jawaban = $kuis->jawabanUser->first(); // satu user satu jawaban
                    if ($jawaban && $jawaban->benar) {
                        $jawabanBenar++;
                    }
                }
            }

            $poin                 = $totalKuis > 0 ? round(($jawabanBenar / $totalKuis) * 100) : 0;
            $bab->total_poin_user = $poin;

            // Kunci bab jika bab sebelumnya tidak lulus
            $bab->is_locked = ! $babSebelumnyaLulus;

            // Jika bab ini tidak lulus (poin < 80), bab berikutnya akan dikunci
            $babSebelumnyaLulus = $poin >= 80;
        }

        return view('materi-edukasi.bab-list', compact('babMateris'));
    }

    public function babDetail($id)
    {
        // Ini view dari route: /materi-edukasi/bab/{id}
        $bab = BabMateri::with('subMateri')->findOrFail($id);
        return view('materi-edukasi.bab-materi', compact('bab'));
    }

    public function submitJawaban(Request $request, $id)
    {
        $materiId    = $id;
        $userId      = Auth::id();
        $jawabanUser = $request->input('jawaban');

        $poin = 0;

        foreach ($jawabanUser as $kuisId => $jawaban) {
            $kuis = Kuis::find($kuisId);

            // Simpan jawaban user
            JawabanUser::updateOrCreate(
                [
                    'user_id' => $userId,
                    'kuis_id' => $kuisId,
                ],
                [
                    'jawaban' => $jawaban,
                    'benar'   => strtolower($kuis->jawaban_benar) === strtolower($jawaban),
                ]
            );

            if (strtolower($kuis->jawaban_benar) === strtolower($jawaban)) {
                $poin += 20;
            }
        }

        return redirect()->back()->with('success', 'Jawaban berhasil dikirim! Total poin: ' . $poin);
    }
}
