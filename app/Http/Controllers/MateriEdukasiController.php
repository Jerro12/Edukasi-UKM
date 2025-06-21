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

        $babMateris = BabMateri::with('subMateri')->withCount('subMateri')->orderBy('id')->get();

        foreach ($babMateris as $bab) {
            $materiIds = $bab->subMateri->pluck('id');
            $kuisIds   = Kuis::whereIn('materi_id', $materiIds)->pluck('id');

            $jumlahKuis  = $kuisIds->count();
            $jumlahBenar = JawabanUser::whereIn('kuis_id', $kuisIds)
                ->where('user_id', $userId)
                ->where('benar', true)
                ->count();

            // Hitung total poin dari jawaban benar
            $totalPoin = $jumlahBenar * 10;

            // Normalisasi ke maksimal 100
            $poinMaks             = $jumlahKuis * 10;
            $bab->total_poin_user = $poinMaks > 0 ? min(100, round(($totalPoin / $poinMaks) * 100)) : 0;
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
            ->orderBy('id')
            ->get();

        $babSebelumnyaLulus = true;

        foreach ($babMateris as $bab) {
            $totalKuis    = 0;
            $jawabanBenar = 0;

            foreach ($bab->subMateri as $materi) {
                foreach ($materi->kuis as $kuis) {
                    $totalKuis++;
                    $jawaban = $kuis->jawabanUser->first();
                    if ($jawaban && $jawaban->benar) {
                        $jawabanBenar++;
                    }
                }
            }

            // Hitung poin user (10 poin per jawaban benar)
            $totalPoinUser = $jawabanBenar * 10;
            $maxPoinBab    = $totalKuis * 10;

            $bab->total_poin_user = $totalPoinUser;
            $bab->is_locked       = ! $babSebelumnyaLulus;

            // Lulus jika mencapai 80% atau lebih
            $persentase         = $maxPoinBab > 0 ? ($totalPoinUser / $maxPoinBab) * 100 : 0;
            $babSebelumnyaLulus = $persentase >= 70;
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
                $poin += 10;
            }
        }

        return redirect()->back()->with('success', 'Jawaban berhasil dikirim! Total poin: ' . $poin);
    }

    public function kuis($id)
    {
        $materi = MateriEdukasi::with(['kuis'])->findOrFail($id);

        // Jika kuis kosong, bisa redirect atau tampilkan pesan
        if ($materi->kuis->isEmpty()) {
            return redirect()->back()->with('info', 'Belum ada kuis untuk materi ini.');
        }

        return view('materi-edukasi.kuis', compact('materi'));
    }

}